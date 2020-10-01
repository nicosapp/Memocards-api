<?php

namespace App\Http\Controllers\Me;

use App\Media\MimeTypes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MediaResourceBase;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth:api']);
  }

  /**
   * Undocumented function
   *
   * @return void
   */
  public function index(Request $request)
  {
    //authorization

    $pagination = 6;

    if ($query = $request->query('search', false)) {
      return MediaResourceBase::collection(
        $request->user()->media()
          ->where('collection_name', $request->get('collection', 'posts'))
          ->where("name", "LIKE", "%{$query}%")
          ->latest('created_at')->paginate($pagination)
      );
    }

    return MediaResourceBase::collection(
      $request->user()->media()
        ->where('collection_name', $request->get('collection', 'posts'))
        ->latest('created_at')->paginate($pagination)
    );
  }

  public function show(Media $media, Request $request)
  {
    //authorization

    return new MediaResourceBase($media);
  }

  public function store(Request $request)
  {

    $this->validate($request, [
      'media.*' => 'required|max:2000|mimetypes:' . implode(',', MimeTypes::$image)
    ]);

    $result = collect($request->media)->map(function ($media) use ($request) {
      return $request->user()->addMedia($media)->toMediaCollection('posts');
    });

    return MediaResourceBase::collection($result);
  }

  public function update(Media $media, Request $request)
  {
    //authorization

    $this->validate($request, [
      'name' => 'string|nullable'
    ]);

    $media->update($request->only('name'));
  }

  public function destroy(Media $media, Request $request)
  {
    //authorization

    $media->delete();
  }
}
