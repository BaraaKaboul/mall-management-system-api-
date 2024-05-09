<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait Images
{
    public function uploadFile($request, $name, $file)
    {
        $file_name = time().'.'.$request->file($name)->getClientOriginalName();
        return $request->file($name)->storeAs('images/'.$file.'/',$file_name);
    }
}
