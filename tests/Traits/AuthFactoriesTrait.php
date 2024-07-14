<?php

namespace Tests\Traits;

use App\Models\Otp;
use App\Models\User;
use Database\Factories\OtpFactory;
use Database\Factories\UserFactory;

trait AuthFactoriesTrait
{
    /**
     * @param int|null $count
     * @return UserFactory
     */
    public function makeUser(int $count = null): UserFactory
    {
        return User::factory()->count($count);
    }

    public function makeOtp(int $count = null): OtpFactory
    {
        return Otp::factory()->count($count);
    }

}
