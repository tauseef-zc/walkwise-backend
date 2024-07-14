<?php

namespace App\Http\Controllers\V1\Api\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\Auth\VerifyUserEmail;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VerificationController extends Controller
{
    private AuthService $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function sendVerificationMail(Request $request): JsonResponse
    {
        $request->validate(['email' => 'required|email|exists:users']);
        VerifyUserEmail::dispatchSync($request->email);

        return response()->json([
            'data' => ['message' => 'verification email send to your email!']
        ], Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function verifyUser(Request $request): JsonResponse
    {
        $payload = $request->validate([
            'email' => 'required|email|exists:users',
            'otp' => 'required|exists:otps',
            'verify_email' => 'sometimes|bool'
        ]);

        list($data, $statusCode) = $this->service->verifyOtp($payload, $request->verify_email ?? false);

        return response()->json($data, $statusCode);
    }
}
