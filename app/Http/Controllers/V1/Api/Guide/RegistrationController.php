<?php

namespace App\Http\Controllers\V1\Api\Guide;

use App\Http\Controllers\Controller;
use App\Http\Requests\Guide\RegisterRequest;
use App\Services\Guide\RegistrationService;
use Illuminate\Http\JsonResponse;

class RegistrationController extends Controller
{
    private RegistrationService $service;

    /**
     * Create a new class instance.
     */
    public function __construct(RegistrationService $service)
    {
        $this->service = $service;
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $userData = [
            'user_id' => $request->user()->id,
            'name' => $request->user()->name,
        ];
        $data = array_merge($request->validated(), $userData);
        list($data, $statusCode) = $this->service->register($data);

        return response()->json($data, $statusCode);
    }

}
