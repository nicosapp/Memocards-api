<?php

namespace App\Http\Controllers\Me;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Me\PostResource;

class PostDashboardController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth:api']);
  }

  public function lastCreated(Request $request)
  {
    return PostResource::collection(
      $request->user()->posts()->lastCreated()->limit(10)->get()
    );
  }

  public function favorites(Request $request)
  {
    return PostResource::collection(
      $request->user()->posts()->favorite()->lastCreated()->limit(10)->get()
    );
  }

  public function mostViewed(Request $request)
  {
    return PostResource::collection(
      $request->user()->posts()->latest('viewed')->lastCreated()->limit(10)->get()
    );
  }

  public function statistics(Request $request)
  {
  }
}
