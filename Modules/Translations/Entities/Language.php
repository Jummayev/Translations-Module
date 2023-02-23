<?php

namespace Modules\Translations\Entities;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use SoftDeletes;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    protected $table = "languages";
    protected $fillable = ["name", "code", "status", "icon_id"];

    public static function rules(): array
    {
        return [
            "name" => "string|required",
            "code" => "string|required",
            "status" => "integer",
            "icon_id" => "integer",
        ];
    }

    /**
     * @throws Exception
     */
    public static function getLangId(string $lang): int
    {
        $id = self::query()->where('code', $lang)->pluck("id")->first();
        if (empty($id)) {
            throw new Exception("$lang lang not found");
        }
        return (int)$id;
    }

    /**
     * @throws Exception
     */
    public static function getLangCode(int $id): string
    {
        $code = self::query()->where('id', $id)->pluck("code")->first();
        if (empty($code)) {
            throw new Exception("$id Language not found");
        }
        return (string)$code;
    }

}
