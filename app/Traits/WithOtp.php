<?php

namespace App\Traits;

use App\Models\Otp;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Random\RandomException;

trait WithOtp
{
    /**
     * otps
     *
     * @return MorphMany
     */
    public function otps(): MorphMany
    {
        return $this->morphMany(Otp::class, 'taggable');
    }

    /**
     * createOtp
     *
     * @return Otp
     * @throws RandomException
     */
    public function createOtp(): Otp
    {
        return $this->otps()->create([
            'otp' => random_int(100000, 999999),
            'expires_at' => now()->addMinutes(60),
        ]);
    }

    /**
     * getOtp
     *
     * @param  string $otp
     * @return Otp | null
     */
    public function getOtp(string $otp): ?Otp
    {
        return $this->otps()->where('otp', $otp)
            ->active()
            ->unverified()
            ->first();
    }


    /**
     * markOtpAsVerified
     *
     * @param  Otp $otp
     * @return bool
     */
    public function markOtpAsVerified(Otp $otp): bool
    {
        return $otp->update(['verified' => true]);
    }

    /**
     * clearVerifiedOtp
     *
     * @return bool
     */
    public function clearVerifiedOtp(): bool
    {
        return $this->otps()->verified()->delete();
    }

}
