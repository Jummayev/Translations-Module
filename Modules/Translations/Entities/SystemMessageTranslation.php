<?php

namespace Modules\Translations\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SystemMessageTranslation extends Model
{
    protected $table = "system_message_translations";
    protected $fillable = ["language_code", "translation", "language_code", "system_message_id"];

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, "language_code", "code");
    }

}
