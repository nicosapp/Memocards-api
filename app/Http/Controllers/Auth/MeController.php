<?php

namespace App\Http\Controllers\Auth;


use App\Media\MimeTypes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Transformers\Users\UserTransformer;

class MeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }
    public function __invoke(Request $request)
    {
        return new UserResource($request->user());
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users,email,'. $request->user()->id,
            'username' => 'required',
            'firstname' => 'required',
            'name' => 'required',
            'password' => 'nullable|min:6',
            // 'password_confirmation' => 'nullable'
        ]);

        $request->user()->update(
            $request->only('email', 'username', 'firstname', 'name', 'password')
        );
    }

    public function avatar(Request $request){

        $this->validate($request, [
            'media' => 'required|max:2000|mimetypes:' . implode(',', MimeTypes::$image)
        ]);

        $request->user()->clearMediaCollection('avatars');
        $request->user()->addMedia($request->media)->toMediaCollection('avatars');
    }
}
