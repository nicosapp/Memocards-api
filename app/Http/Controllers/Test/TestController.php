<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function __invoke(Request $request){
        dd("Test works");
    }

    public function someAction(Request $request){
        dd('Some actions');
    }
}
