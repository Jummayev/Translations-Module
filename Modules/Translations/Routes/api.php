<?php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use Illuminate\Support\Facades\Route;
use Modules\Translations\Http\Controllers\LanguageController;

Route::middleware("api")->group(function () {
    Route::prefix("admin/translations")->group(function () {
        Route::get("list", "ranslationsController@list");
        Route::post("list", "ranslationsController@change");
    });
});

Route::prefix("translations")->group(function () {
    Route::get("/translation/{language}", "ranslationsController@index");
    Route::post("/translation/{language}", "ranslationsController@store");
    Route::delete("/{id:d+}", "ranslationsController@destroy");
    Route::post("/translation", "ranslationsController@createTranslation");
});

Route::prefix("v1")->controller(LanguageController::class)->group(function (){
   Route::prefix("admin/languages")->middleware("api")->group(function (){
      Route::get("/", "adminIndex");
      Route::post("/", "store");
      Route::put("{language}", "update")->whereNumber("language");
      Route::get("{language}", "show")->whereNumber("language");
      Route::delete("{language}", "destroy")->whereNumber("language");
   });
   Route::get("languages", "clientIndex");
});

