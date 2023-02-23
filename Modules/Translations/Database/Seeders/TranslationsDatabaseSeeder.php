<?php

namespace Modules\Translations\Database\Seeders;

use Illuminate\Database\Seeder;

class TranslationsDatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            LanguageSeeder::class
        ]);
    }
}
