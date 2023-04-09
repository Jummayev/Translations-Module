<?php

namespace Modules\Translations\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SystemMessages extends Model
{
    protected $table = "system_messages";

    const CATEGORY_BACKEND = 0;
    const CATEGORY_FRONTEND = 1;
    const CATEGORY_MOBILE = 2;

    protected $fillable = ["category", "message"];

    public function translations(): HasMany
    {
        return $this->hasMany(SystemMessageTranslation::class, "system_message_id");
    }
}
