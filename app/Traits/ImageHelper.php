<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait ImageHelper
{
    public function uploadImage(string $fileName, string $path = 'images/'): string
    {
        $renderedName = time() . '_' . Str::random(10) . '.jpg';

        if(request()->has($fileName) && is_string(request()->input($fileName))){
            $image_data = explode(',', request()->input($fileName))[1];
            $image = base64_decode($image_data);
            $path = $path . $renderedName;
            Storage::put($path, $image);
        }else{
            Storage::putFileAs(
                $path, request()->file($fileName), $renderedName
            );
        }

        return $fileName;
    }

}
