<?php

namespace App\Services\Auth;

use App\Enums\UserTypesEnum;
use App\Services\BaseService;

class UserService extends BaseService
{
    /**
     * @param UserTypesEnum $userType
     * @return void
     */
    public function updateRegisterFields(UserTypesEnum $userType = UserTypesEnum::GUIDE): void
    {
        if(request()->has('gender')){
            auth()->user()->update([
                'gender' => request()->gender,
                'user_type' => $userType
            ]);
        }

        if(request()->has('phone')){
            auth()->user()->update(['onboarding' => false]);
        }

        if(request()->has('primary_lang')){
            auth()->user()->update(['primary_lang' => request()->primary_lang]);
        }

        if(request()->has('other_lang')){
            auth()->user()->update(['other_lang' => json_decode(request()->other_lang, true)]);
        }
    }
}
