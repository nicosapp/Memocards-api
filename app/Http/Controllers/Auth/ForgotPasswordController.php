<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Send password reset link
     *
     * @param Request $request
     * @return void
     */
    public function __invoke(Request $request)
    {
        dd(url('/password/reset'));
        // return $this->sendResetLinkEmail($request);
    }


    /**
     * Get the response for a successful password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */

    // protected function sendResetLinkResponse(Request $request, $response)
    // {
    //     return response()->json([
    //         'message' => 'Password reset email sent.',
    //         'data' => $response
    //     ]);
    // }
    // /**
    //  * Get the response for a failed password reset link.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  string  $response
    //  * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
    //  */

    // protected function sendResetLinkFailedResponse(Request $request, $response)
    // {
    //     return response()->json([
    //         'message' => 'Email could not be sent to this email address.'
    //     ]);
    // }
}
