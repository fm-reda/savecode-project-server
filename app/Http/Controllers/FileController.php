<?php

// namespace App\Http\Controllers\api\v1;
namespace App\Http\Controllers;

use App\Photo;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;

class FileController extends Controller
{
    public function getPhoto()
    {
        $photo = Photo::all();

        // dd($photo);
        return response()->json($photo, 200);
    }
    public function fileDown()
    {
        // dd(public_path('storage/users/default.png'));
        return response()->download(public_path('storage/users/default.png'), "user img");
    }
}
