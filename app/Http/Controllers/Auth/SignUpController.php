<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class SignUpController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email|unique:users,email',
            'username' => 'required',
            'firstname' => 'required',
            'name' => 'required',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $user = User::create(
            $request->only('email', 'username', 'firstname', 'name', 'password')
        )->sendApiEmailVerificationNotification();
        // instead of sendEmailVerificationNotification

        return new UserResource($user);
    }
}
