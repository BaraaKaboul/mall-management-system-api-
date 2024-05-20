<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait ImagesTrait
{
    public function uploadFile($request, $disk)
    {
        $file = $request->file('photo');
            $imageName = time() . '.' . $file->getClientOriginalName();
            $file->storeAs($disk, $imageName);
            return $imageName;
        }

}
