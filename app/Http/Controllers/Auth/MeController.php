<?php

namespace App\Http\Controllers\Auth;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transformers\Users\UserTransformer;

class MeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }
    public function __invoke(Request $request)
    {
        return fractal()
            ->item($request->user())
            ->transformWith(new UserTransformer())
            ->toArray();
    }
}
