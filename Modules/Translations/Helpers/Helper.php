<?php

function t($key = null, $replace = [], $locale = null): string|null
{
    if (is_null($key)) {
        return $key;
    }
    if (config("translations.database_sync")){
        $tes = "........................";
    }

    return trans($key, $replace, $locale);
}
