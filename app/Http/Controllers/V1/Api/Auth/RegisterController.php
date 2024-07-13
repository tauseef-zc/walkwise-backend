<?php

namespace App\Http\Controllers\V1\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    private AuthService $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        list($data, $statusCode) = $this->service->register($data);

        return response()->json($data, $statusCode);
    }
}
