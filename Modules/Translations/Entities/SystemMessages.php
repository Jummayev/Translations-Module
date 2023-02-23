<?php

namespace Modules\Translations\Entities;

use Illuminate\Database\Eloquent\Model;

class SystemMessages extends Model
{
    protected $table = "system_messages";

    const CATEGORY_BACKEND = 0;
    const CATEGORY_FRONTEND = 1;
    const CATEGORY_MOBILE = 2;

    protected $fillable = ["category", "message"];
}
