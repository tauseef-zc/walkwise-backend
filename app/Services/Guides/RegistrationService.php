<?php

namespace App\Services\Guides;

use App\Models\Guide;
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
        if(request()->has('avatar') || request()->hasFile('avatar')){
            $data['avatar'] = $this->uploadImage('avatar', 'guides/images/');
        }

        if (isset($data['expertise'])) {
            $data['expertise'] = json_decode($data['expertise']);
        }

        if(request()->hasFile('tourism_license')){
            $data['documents'][] = request()->file('tourism_license')->store('guides/documents/');
        }

        if(request()->hasFile('registration_certificate')){
            $data['documents'][] = request()->file('registration_certificate')->store('guides/documents/');
        }

        if(request()->has('gender')){
            auth()->user()->update(['gender' => request()->gender]);
        }

        if(request()->has('phone')){
            auth()->user()->update(['onboarding' => false]);
        }

        $guide = $this->model->updateOrCreate(['user_id' => $data['user_id']], $data);
        return $this->payload(['guide' => $guide], Response::HTTP_CREATED);
    }

}
