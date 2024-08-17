<?php

namespace App\Http\Controllers\V1\Api\Traveler;

use App\Http\Controllers\Controller;
use App\Http\Requests\Traveler\RegisterRequest;
use App\Services\Traveler\RegistrationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    private RegistrationService $service;

    public function __construct(RegistrationService $service)
    {
        $this->service = $service;
    }

    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $userData = [
            'user_id' => $request->user()->id,
            'name' => $request->user()->name,
            'verified_at' => now(),
        ];

        $data = array_merge($request->validated(), $userData);
        list($data, $statusCode) = $this->service->register($data);

        return response()->json($data, $statusCode);
    }
}
