<?php

namespace App\Services\Guide;

use App\Enums\UserTypesEnum;
use App\Models\Guide;
use App\Services\Auth\UserService;
use App\Services\BaseService;
use Symfony\Component\HttpFoundation\Response;

class RegistrationService extends BaseService
{
    private Guide $model;

    /**
     * Create a new class instance.
     */
    public function __construct(Guide $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $data
     * @return array
     */
    public function register(array $data): array
    {
        if (isset($data['expertise'])) {
            $data['expertise'] = json_decode($data['expertise'], true);
        }

        $data = $this->uploadDocuments($data);

        $guide = $this->model->updateOrCreate(['user_id' => $data['user_id']], $data);
        app(UserService::class)->updateRegisterFields(UserTypesEnum::GUIDE);

        return $this->payload(['guide' => $guide], Response::HTTP_CREATED);
    }

    /**
     * @param array $data
     * @return array
     */
    private function uploadDocuments(array $data): array
    {
        if(request()->has('avatar') || request()->hasFile('avatar')){
            $data['avatar'] = $this->uploadImage('avatar', 'guides/images/');
        }

        $documents = [
            'tourism_license',
            'registration_certificate'
        ];

        foreach ($documents as $document) {
            if(request()->hasFile($document)){
                $data['documents'][] = request()->file($document)->store('guides/documents/');
            }
        }

        return $data;
    }



}
