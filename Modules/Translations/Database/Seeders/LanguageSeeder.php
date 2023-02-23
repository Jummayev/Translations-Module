<?php

namespace Modules\Translations\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Translations\Entities\Language;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $now = now();

        $languages = [
            [
                'name' => 'Uzbek',
                'code' => 'oz',
                "status" => Language::STATUS_ACTIVE,
                "created_at" => $now,
                "updated_at" => $now,
            ], [
                'name' => 'Узбек',
                'code' => 'uz',
                "status" => Language::STATUS_ACTIVE,
                "created_at" => $now,
                "updated_at" => $now,
            ], [
                'name' => 'Русский',
                'code' => 'ru',
                "status" => Language::STATUS_ACTIVE,
                "created_at" => $now,
                "updated_at" => $now,
            ], [
                'name' => 'English',
                'code' => 'en',
                "status" => Language::STATUS_ACTIVE,
                "created_at" => $now,
                "updated_at" => $now,
            ],
//            [
//                'name' => 'Arabic',
//                'code' => 'ar',
//                "status" => Language::STATUS_ACTIVE,
//                "created_at" => $now,
//                "updated_at" => $now,
//            ], [
//                'name' => 'French',
//                'code' => 'fr',
//                "status" => Language::STATUS_ACTIVE,
//                "created_at" => $now,
//                "updated_at" => $now,
//            ], [
//                'name' => 'Spanish',
//                'code' => 'es',
//                "status" => Language::STATUS_ACTIVE,
//                "created_at" => $now,
//                "updated_at" => $now,
//            ], [
//                'name' => 'Chinese',
//                'code' => 'zh',
//                "status" => Language::STATUS_ACTIVE,
//                "created_at" => $now,
//                "updated_at" => $now,
//            ], [
//                'name' => 'Japanese',
//                'code' => 'ja',
//                "status" => Language::STATUS_ACTIVE,
//                "created_at" => $now,
//                "updated_at" => $now,
//            ], [
//                'name' => 'German',
//                'code' => 'de',
//                "status" => Language::STATUS_ACTIVE,
//                "created_at" => $now,
//                "updated_at" => $now,
//            ], [
//                'name' => 'Kazakh',
//                'code' => 'kz',
//                "status" => Language::STATUS_ACTIVE,
//                "created_at" => $now,
//                "updated_at" => $now,
//            ], [
//                'name' => 'Kazakh',
//                'code' => 'kz',
//                "status" => Language::STATUS_ACTIVE,
//                "created_at" => $now,
//                "updated_at" => $now,
//            ], [
//                'name' => 'Kyrgyz',
//                'code' => 'ky',
//                "status" => Language::STATUS_ACTIVE,
//                "created_at" => $now,
//                "updated_at" => $now,
//            ], [
//                'name' => 'Turkmen',
//                'code' => 'tk',
//                "status" => Language::STATUS_ACTIVE,
//                "created_at" => $now,
//                "updated_at" => $now,
//            ], [
//                'name' => 'Turkish',
//                'code' => 'tr',
//                "status" => Language::STATUS_ACTIVE,
//                "created_at" => $now,
//                "updated_at" => $now,
//            ], [
//                'name' => 'Tajik',
//                'code' => 'tg',
//                "status" => Language::STATUS_ACTIVE,
//                "created_at" => $now,
//                "updated_at" => $now,
//            ],
        ];
        Language::query()->insert($languages);
    }
}
