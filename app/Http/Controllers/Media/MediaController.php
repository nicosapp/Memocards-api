<?php

namespace App\Http\Controllers\Media;

use App\Media\MimeTypes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MediaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'media.*' => 'required|mimetypes:' . implode(',', MimeTypes::all())
        ]);

        $result = collect($request->media)->map(function($media){
            return $this->addMedia($media);
        });
    }

    protected function addMedia($media){

        // $tweetMedia = TweetMedia::create([]);

        // $tweetMedia->baseMedia()
        //     ->associate($tweetMedia->addMedia($media)->toMediaCollection())
        //     ->save();
    }
}
