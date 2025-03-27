<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{
    /**
     * Return a 200 response JSON
     * @param array $data
     * @return JsonResponse
     */
    protected function responseSuccess(array $data = []) : JsonResponse
    {
        return response()->json($data);
    }
}
