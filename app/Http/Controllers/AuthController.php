<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\responseJsonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use responseJsonTrait;
    public function login(Request $request)
    {
        $user = User::where('email',$request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password))
        {
            return $this->fail('The provided credentials are incorrect.',505);
        }

        $token = $user->createToken('my-app-token')->plainTextToken;

        $data = [
            'user'=>$user,
            'token'=>$token,
        ];
        return $this->fetchData('You have been authenticated successfully',200,'data',$data);
    }
}
