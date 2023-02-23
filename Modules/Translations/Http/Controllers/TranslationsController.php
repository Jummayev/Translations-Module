<?php

namespace Modules\Translations\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Translations\Entities\SystemMessages;

class TranslationsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function adminIndex(Request $request)
    {
        return response()->json(SystemMessages::all());
    }

    /**
     * Update the specified resource in storage
     * @param Request $request
     * @param SystemMessages $systemMessage
     * @return JsonResponse
     */
    public function adminUpdate(Request $request, SystemMessages $systemMessage)
    {
        return response()->json(["message" => ""]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     */
    public function frontendStore(Request $request)
    {
        return response()->json(["message" => ""]);
    }

    /**
     * Remove the specified resource from storage.
     * @param SystemMessages $systemMessage
     * @return JsonResponse
     */
    public function destroy(SystemMessages $systemMessage)
    {
        $systemMessage->delete();
        return response()->json(["message" => "deleted"]);
    }
}
