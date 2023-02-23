<?php

namespace Modules\Translations\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SystemMessageTranslation extends Model
{
    protected $table = "system_message_translations";
    protected $fillable = ["language_code", "translation", "language_code", "system_message_id"];

}
