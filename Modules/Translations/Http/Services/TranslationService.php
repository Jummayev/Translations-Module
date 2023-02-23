<?php

namespace Modules\Translations\Http\Services;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Modules\Translations\Entities\Language;
use Modules\Translations\Entities\SystemMessages;
use Modules\Translations\Entities\SystemMessageTranslation;

class TranslationService
{

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $messages = SystemMessages::all();
        $json = [];
        if (count($messages) > 0) {
            foreach ($messages as $message) {
                $translate = SystemMessageTranslation::query()->where("id", $message->id)->where("language", $request->get("language"))->first()->toArray();
                if (!empty($translate)) {
                    $json[$message["message"]] = $translate["message"];
                    continue;
                }
                $json[$message["message"]] = $message["message"];
            }
        }

        return response()->json($json);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $data = $request->toArray();
        if (empty($message = array_shift($data)) && count($data) < 3) {
            return;
        }

        $model = SystemMessages::query()->where("message", $message)->first();
        if ($model) {
            return $model;
        }

        $model = SystemMessages::query()->create([
            "category" => "react",
            "message" => $message
        ]);
        SystemMessageTranslation::generateJs();
        return $model;
    }

    public
    function createTranslation(Request $request)
    {
        $request->validate(SystemMessageTranslation::rules());

        $translate = SystemMessageTranslation::find($request->id)
            ->where(["language" => $request->language])
            ->first();

        if (is_object($translate)) {
            $translate->translation = $request->translation;
            $translate->save();
            return $translate;
        }
        return SystemMessageTranslation::create([
            "id" => $request->id,
            "language" => $request->language,
            "translation" => $request->translation
        ]);
    }

    public function list(Request $request)
    {
        $message = $request->get("message");
        if (!empty($message)) {
            $query = SystemMessages::query();
            $query->select("system_messages.*");
            $query->leftJoin("system_message_translations", "system_message_translations.system_message_id", "=", "system_messages.id");
            $query->where("system_messages.message", "ILIKE", "%" . $message . "%");
            $query->orWhere("system_message_translations.translation", "ILIKE", "" % "" . $message . "" % "");
            $sources = $query->orderBy("system_messages.id", "DESC")->get();
        } else {
            $sources = SystemMessages::query()->orderBy("id", "DESC")->get();
        }
        $data = [];

        foreach ($sources as $key => $sours) {
            $languages = Language::query()->where("status", Language::STATUS_ACTIVE)->get();
            $data_lang = [];
            foreach ($languages as $lang) {
                $model = SystemMessageTranslation::query()->where("system_message_id", $sours->id)->where( "language", $lang->code)->first();
                if (!empty($model)) {
                    $data_lang[$lang->code] = $model->translation;
                }
            }

            $data[$key] = [
                "id" => $sours->id,
                "message" => $sours->message,
                "uz" => empty(array_key_exists("uz", $data_lang)) ? "" : $data_lang["uz"],
                "ru" => empty(array_key_exists("ru", $data_lang)) ? "" : $data_lang["ru"],
                "en" => empty(array_key_exists("en", $data_lang)) ? "" : $data_lang["en"],
            ];
        }

        return response()->json($this->paginate($data, $request->per_page));
    }

    public function paginate($items, $perPage = 50, $page = null, $options = []): LengthAwarePaginator
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function change(Request $request, SystemMessages $systemMessage): JsonResponse
    {
        $request->validate([
            "language" => "required|string|exists:languages,code",
            "translation" => "required|string",
        ]);
        $model = SystemMessageTranslation::where("id", $systemMessage->id)
            ->where("language", $request->get("language"));
        $model_exists = clone $model;
        if ($model_exists->exists()) {
            $system_message_translation = clone $model;
            $system_message_translation->update(["translation" => $request->get("translation")]);
        }else{
            $system_message_translation = SystemMessageTranslation::create([
                "id" => $request->id,
                "language" => $request->language,
                "translation" => $request->translation
            ]);
        }

        SystemMessageTranslation::generateJs();
        return response()->json($this->getData($system_message_translation));
    }

    public function getData(SystemMessages $systemMessages): array
    {
        $languages = Language::query()->where("status", Language::STATUS_ACTIVE)->get();
        $data_lang = [];
        foreach ($languages as $lang) {
            $src = SystemMessageTranslation::query()->where("system_message_id", $systemMessages->id)->where("language", $lang->code)->first();
            if (!empty($src)) {
                $data_lang[$lang->code] = $src->translation;
            }
        }
        return [
            "id" => $systemMessages->id,
            "message" => $systemMessages->message,
            "uz" => empty(array_key_exists("uz", $data_lang)) ? "" : $data_lang["uz"],
            "ru" => empty(array_key_exists("ru", $data_lang)) ? "" : $data_lang["ru"],
            "en" => empty(array_key_exists("en", $data_lang)) ? "" : $data_lang["en"],
        ];
    }

}
