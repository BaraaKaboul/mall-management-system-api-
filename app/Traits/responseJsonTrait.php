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
            'msg'=>$msg,
            'status'=>$code,
        ]);
    }

    public function fetchData($msg, $code, $key, $value)
    {
        return response()->json([
           'msg'=>$msg,
           'status'=>$code,
           $key=>$value,
        ]);
    }

}
