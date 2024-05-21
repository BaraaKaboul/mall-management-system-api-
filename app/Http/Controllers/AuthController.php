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

    public function register(Request $request)
    {
        try {
            $checkUser = User::where('email',$request->email)->first();

            if ($checkUser)
            {
                return response()->json([
                    'msg' => 'this email is already taken',
                    'code' => 203,
                ]);
            }
            User::create([
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
                'name'=>$request->name,
            ]);

            return $this->success('Account has been created successfully', 200);

        }
        catch (\Exception $e) {
            return $this->fail($e->getMessage(), 400);
        }
    }
}
