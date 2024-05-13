<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait ImagesTrait
{
    public function uploadFile($request, $disk)
    {


            $imageName = time() . '.' . $request->photo->getClientOriginalName();
            $request->file('photo')->storeAs($disk,$imageName);
            return $imageName;

    }
}
