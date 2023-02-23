<?php

namespace Modules\Translations\Helpers;


use Illuminate\Support\Facades\DB;
use Modules\Translations\Entities\Language;
use Modules\Translations\Entities\SystemMessages;
use Modules\Translations\Entities\SystemMessageTranslation;

class Helper
{


    public static function generateJson(int $category): bool
    {
        error_reporting(2245);
        $languages = Language::query()->where("status", Language::STATUS_ACTIVE)->get()->toArray();
        foreach ($languages as $lang) {

            $messages = SystemMessages::query()
                ->leftJoin("system_message_translations", "system_messages.id", "=", "system_message_translations.system_message_id")
                ->select("system_messages.id", "system_messages.message", "system_message_translations.language_code", "system_message_translations.translation")
                ->whereRaw("system_message_translations.language_code = {$lang["code"]} or system_message_translations.language_code is null)")
                ->where("system_messages.category", "=", $category)
                ->get()->toArray();

            $data = [];
            foreach ($messages as $message) {
                if (!empty($message['translation'])) {
                    $data[$message["message"]] = $message['translation'];
                    continue;
                }
                $data[$message["message"]] = $message["message"];
            }
            $paths = config("translations.path");
            foreach ($paths as $path) {
                $link = $path . "/locales/" . $lang["code"] . "/translation.json";
                if (!is_dir($path . "/locales/" . $lang["code"])) {
                    mkdir($path . "/locales/" . $lang['code']);
                }
                unlink($path . "/locales/" . $lang["code"]);
                $fp = fopen($link, "w");
                fwrite($fp, json_encode($data, JSON_UNESCAPED_UNICODE));
                fclose($fp);
            }
        }
        return true;
    }

    public static function gene($lang)
    {
        $lang = Language::where(["code" => $lang])->first();
        error_reporting(2245);
        $messages = SystemMessages::all();

        $data = [];
        foreach ($messages as $message) {
            $translation = SystemMessageTranslation::query()->where([
                "id" => $message["id"],
                "language_code" => $lang->code
            ])->first();
            if (is_object($translation) && strlen($translation->translation) !== 0) {
                $data[$message["message"]] = $translation->translation;
                continue;
            }
            $data[$message["message"]] = $message["message"];
        }

        $path = config("translations.path");


        return $data;
    }


}
