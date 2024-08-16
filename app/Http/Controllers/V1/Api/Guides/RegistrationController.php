<?php

namespace App\Http\Controllers\V1\Api\Guides;

use App\Http\Controllers\Controller;
use App\Http\Requests\Guides\RegisterRequest;
use App\Services\Guides\RegistrationService;
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
