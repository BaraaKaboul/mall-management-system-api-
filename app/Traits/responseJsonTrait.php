<?php

namespace App\Traits;

trait responseJsonTrait
{
    public function success($msg, $code)
    {
        return response()->json([
            $msg,
            $code,
        ]);
    }

    public function fail($msg, $code)
    {
        return response()->json([
            $msg,
            $code,
        ]);
    }

}
