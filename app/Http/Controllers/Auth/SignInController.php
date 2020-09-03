<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SignInController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(!$token = auth()->attempt($request->only('email', 'password'))){
            return response()->json([
                'errors' =>[
                    'email' =>[
                        'Could not sign you in with those details'
                    ]
                ]
                    ], 422);
        }

        return response()->json([
            'data' => compact('token')
        ]);
    }
}
