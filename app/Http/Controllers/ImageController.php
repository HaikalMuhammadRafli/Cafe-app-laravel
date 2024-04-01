<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function upload($image, $masakan) {
        $path = $image->store('files');
        $input['url'] = $path;
        $input['id_masakan'] = $masakan->id;
        return Image::create($input);
    }
}
