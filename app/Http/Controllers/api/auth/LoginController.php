<?php

namespace App\Http\Controllers\api\auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request){
      $request->validate([
        'email' => 'required|email',
        'password' => 'required',
       ]);

       try{
        if(Auth::attempt($request->only(['email', 'password']))){
            $user= Auth::User();
            $token = $user->createToken('app')->accessToken;
            return response([
                'token' => $token,
                'user' => $user,
            ],  200);
        }
       }catch(Exception $exception){
        return response([
            'message' => $exception->getMessage(),
        ], 400);

       }
       return response('Ivalid Email or Password', 401);
    }
}
