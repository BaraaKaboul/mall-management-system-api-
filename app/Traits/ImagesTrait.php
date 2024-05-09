<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait ImagesTrait
{
    public function uploadFile($photo, $folder)
    {
        $photo->store('/', $folder);
        $fileName = $photo->hashName();
         $path = 'images/' . $folder . '/' . $fileName;
        return $fileName;
    }
}
