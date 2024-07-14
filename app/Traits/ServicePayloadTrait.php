<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Response;

trait ServicePayloadTrait
{

    /**
     * @param array $data
     * @param int $code
     * @return array
     */
    public function payload(array $data, int $code = Response::HTTP_OK): array
    {
        return [
            ['data' => $data],
            $code
        ];
    }

    /**
     * @param string $message
     * @param int $code
     * @return array
     */
    public function error(string $message, int $code): array
    {
        return [
            ['error' => $message],
            $code
        ];
    }
}
