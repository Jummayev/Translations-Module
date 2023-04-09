<?php

namespace Modules\Translations\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Translations\Entities\Language;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function adminIndex(): JsonResponse
    {
        return response()->json(Language::all());
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function clientIndex(): JsonResponse
    {
        $languages = Language::query()->where("status", Language::STATUS_ACTIVE);
        return response()->json(Language::all());
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate(Language::rules());

        $language = Language::query()->create($request->all());

        return response()->json($language);
    }

    /**
     * Show the specified resource.
     * @param Language $language
     * @return JsonResponse
     */
    public function show(Language $language): JsonResponse
    {
        return response()->json($language);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Language $language
     * @return JsonResponse
     */
    public function update(Request $request, Language $language): JsonResponse
    {
        $request->validate(Language::rules());

        $language->update($request->all());

        return response()->json($language);
    }

    /**
     * Remove the specified resource from storage.
     * @param Language $language
     * @return JsonResponse
     */
    public function destroy(Language $language): JsonResponse
    {
        $language->delete();
        return response()->json(["message" => "deleted"]);
    }
}
