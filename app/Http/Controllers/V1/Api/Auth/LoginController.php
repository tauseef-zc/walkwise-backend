<?php

namespace App\Http\Controllers\V1\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    private AuthService $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();
        list($data, $statusCode) = $this->service->login($credentials);

        return response()->json($data, $statusCode);
    }
}
