<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Access\AuthorizationException;

class ApiVerificationController extends Controller
{
    use VerifiesEmails;


    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('signed')->only('verify'); //verify que l'url est signé
        // $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
    * Show the email verification notice.
    *
    */
    public function show()
    {
        //
    }
    /**
    * Mark the authenticated user’s email address as verified.
    * Overwrite VerifiesEmails->verify
    *
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function verify(Request $request)
    {

        // if (! hash_equals((string) $request->route('id'), (string) $request->user()->getKey())) {
        //     throw new AuthorizationException;
        // }

        // if (! hash_equals((string) $request->route('hash'), sha1($request->user()->getEmailForVerification()))) {
        //     throw new AuthorizationException;
        // }

        $verification = $request->user()->verification;
        // dd($verification);
        // return;

        if(!$verification){
            return response()->json([
                'error' => 'No record found! Please try to resend a verification email'
            ], 422);
        }
        if($verification->created_at->addMinutes(30)->lt(Carbon::now())){
            return response()->json([
                'error' => 'Token expires, you need to resend an email for verification'
            ], 422);
        }

        if(!Hash::check($request->route('numbers'), $verification->token)){

            if($verification->tentative >= 3){
                $verification->delete();

                return response()->json([
                    'error' => 'Too many tentatives! Please ask for a new verification email'
                ], 422);
            }

            $verification->fill([
                'tentative' => $verification->tentative + 1
            ])->save();

            return response()->json([
                'error' => 'Secret does not match'
            ], 422);

            // throw new AuthorizationException;
        }


        if ($request->user()->hasVerifiedEmail()) {
            return response()->json([
                'error' => 'User already have verified email!'
            ], 422);
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        $verification->delete(); //delete verification hash secret
        
        return response()->json([
            'message' => 'Email verified'
        ], 200);
    }

    /**
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    * Overwrite VerifiesEmails->verify
    */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json([
                'error' => 'User already have verified email!'
            ], 422);
        }

        $verification = $request->user()->verification;
        if($verification
            && $verification->created_at->addMinutes(5)->gt(Carbon::now())){
            return response()->json([
                'error' => 'An email has already been sent, please wait 5 min before requesting a new email!'
            ], 422);
        }

        $request->user()->sendApiEmailVerificationNotification();

        return response()->json([
            'message' => 'The notification has been resubmitted!'
        ], 200);
    }

}
