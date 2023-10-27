<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use Str;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $file = $request->file('image');
        $name = Str::random(10);

        $url = Storage::putFileAs('images', $file, $name. '.' . $file->extension());

        return [
            'url' => env('APP_URL') . '/' . $url
        ];
    }
}
