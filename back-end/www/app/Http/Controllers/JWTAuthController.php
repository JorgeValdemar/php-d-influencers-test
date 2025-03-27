<?php

namespace App\Http\Controllers;

use App\Services\JWTAuthService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\JsonResponse;

class JWTAuthController extends Controller
{
    function __construct(
        private JWTAuthService $jwtAuthService
    ) {}

    /**
     * Summary of register a new user
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $response = $this->jwtAuthService->register($request->all());
        return response()->json($response, 201);
    }

    /**
     * Summary of login the user
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        $response = $this->jwtAuthService->login($credentials);

        return parent::responseSuccess($response);
    }

    /**
     * Summary of logout the user
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Você deslogou com sucesso, até a próxima!']);
    }
}
