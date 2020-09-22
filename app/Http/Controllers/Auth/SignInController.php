<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SignInController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(!$token = Auth::attempt($request->only('email', 'password'))){
            return response()->json([
                'errors' =>[
                    'email' =>[
                        'Could not sign you in with those details'
                    ]
                ]
                    ], 422);
        } 
        // else if(Auth::user()->email_verified_at === NULL){
        //     return response()->json([
        //         'error'=>'Please Verify Email'
        //     ], 401);
        // } 

        return response()->json([
            'data' => compact('token')
        ]);
       
    }
}
