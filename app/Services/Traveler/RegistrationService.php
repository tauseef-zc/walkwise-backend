<?php

namespace App\Services\Traveler;

use App\Enums\UserTypesEnum;
use App\Models\Traveler;
use App\Services\Auth\UserService;
use App\Services\BaseService;
use Symfony\Component\HttpFoundation\Response;

class RegistrationService extends BaseService
{
    private Traveler $model;

    public function __construct(Traveler $model)
    {
        $this->model = $model;
    }

    public function register(array $data): array
    {
        $jsonFields = ['accessibility', 'interests', 'emergency_contact'];
        foreach ($jsonFields as $jsonField) {
            if (isset($data[$jsonField])) {
                $data[$jsonField] = json_decode($data[$jsonField], true);
            }
        }

        $data = $this->uploadDocs($data);
        $traveler = $this->model->updateOrCreate(['user_id' => $data['user_id']], $data);
        app(UserService::class)->updateRegisterFields(UserTypesEnum::TRAVELER);

        return $this->payload(['traveler' => $traveler], Response::HTTP_CREATED);
    }

    private function uploadDocs(array $data): array
    {
        if(request()->has('avatar') || request()->hasFile('avatar')){
            $data['avatar'] = $this->uploadImage('avatar', 'traveler/images/');
        }

        if(request()->hasFile('passport_image')){
            $data['passport_image'] = request()->file('passport_image')->store('traveler/documents');
        }

        return $data;
    }
}
