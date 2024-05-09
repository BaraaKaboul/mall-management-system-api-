<?php

namespace App\Traits;

trait responseJson
{
    public function sucess()
    {
        return response()->json(
            'data has been created sucssessfully',
            200,
        );
    }


}
