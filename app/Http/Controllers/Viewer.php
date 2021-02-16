<?php

namespace App\Http\Controllers;

use App\Events\VideoViewer;
use App\Models\Video;
use Illuminate\Http\Request;

class Viewer extends Controller
{
    public function getVideo()
    {
        $video = Video::first();
        event(new VideoViewer($video));
        return view('video')->with('video', $video);
    }
}
