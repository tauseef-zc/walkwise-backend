<?php

namespace App\Services;

use App\Http\Resources\Auth\UserResource;
use App\Jobs\Auth\VerifyUserEmail;
use App\Models\User;
use App\Notifications\Auth\ForgotPasswordNotification;
use App\Notifications\Auth\ResetPasswordNotification;
use App\Notifications\Auth\VerifyEmailNotification;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class AuthService extends BaseService
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * login
     *
     * @param  array $credentials
     * @return array
     */
    public function login(array $credentials): array
    {
        try {

            if (!auth()->attempt($credentials)) {
                return $this->error('The provided credentials are incorrect.', Response::HTTP_UNAUTHORIZED );
            }

            $user = auth()->user();

            throw_if(!$user->hasVerifiedEmail(), ValidationException::withMessages([
                'Your email address is not verified.'
            ]));

            return $this->payload([
                'accessToken' => $user->createToken($user->email)->plainTextToken,
                'user'  => new UserResource($user)
            ]);

        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), Response::HTTP_BAD_REQUEST );
        }
    }

    /**
     * @param array $payload
     * @return array
     */
    public function register(array $payload): array
    {
        try {

            $user = $this->user->create($payload);
            VerifyUserEmail::dispatch($user->email);

            $user->refresh();

            return $this->payload([
                'message'  => 'User has been created.',
                'user' => new UserResource($user)
            ],
            Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), Response::HTTP_BAD_REQUEST );
        }
    }

    /**
     * forgotPassword
     *
     * @param string $email
     * @return array
     */
    public function forgotPassword(string $email): array
    {
        $user = $this->user->where('email', $email)->first();

        $otp = $user->createOtp();
        $user->notify(new ForgotPasswordNotification($otp->otp));

        return $this->payload(['message'  => 'Reset password otp sent to your email address']);
    }


    /**
     * @param array $payload
     * @param bool $verifyEmail
     * @return array
     */
    public function verifyOtp(array $payload, bool $verifyEmail = false): array
    {
        $user = $this->user->where(['email' => $payload['email']])->first();

        if ($otp = $user->getOtp($payload['otp'])) {

            $user->markOtpAsVerified($otp);

            if ($verifyEmail) {
                return $this->verifyUserEmail($user);
            }

            return $this->payload([
                'message'  => 'The otp has been verified.',
                'accessToken' => $user->createToken($user->id, ['reset.password'], now()->addMinutes(30))->plainTextToken,
            ]);
        }

        return $this->error('The otp is incorrect.', Response::HTTP_BAD_REQUEST );
    }

    /**
     * @param User $user
     * @return array
     */
    public function verifyUserEmail(User $user): array
    {
        $user->markEmailAsVerified();
        return $this->payload(['message'  => sprintf('The email %s has been verified.', $user->email)]);
    }

    /**
     * notifyVerification
     *
     * @param  User $user
     * @param  string $otp
     * @return void
     */
    public function notifyVerification(User $user, string $otp): void
    {
        $user->notify(new VerifyEmailNotification($otp));
    }

    /**
     * @param array $payload
     * @return array
     */
    public function resetPassword(array $payload): array
    {
        $user = $this->user->where('email', $payload['email'])->first();

        if (!$user) {
            return $this->error('User not found', Response::HTTP_NOT_FOUND);
        }

        $user->update(['password' => bcrypt($payload['password'])]);
        $user->notify(new ResetPasswordNotification());

        // Clear tokens
        $user->tokens()->delete();

        return $this->payload(['message'  => 'Password has been reset'], Response::HTTP_ACCEPTED);
    }
}
