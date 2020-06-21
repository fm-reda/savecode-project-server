<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function uploadPhotos(Request $request)
    {
        // $to = $request->name;
        $file = $request->file('file');
        $ext = $file->extension();
        // dd($ext);
        $name = Str::random(20) . '.' . $ext;
        list($width, $height) = getimagesize($file);
        $path = Storage::disk('public')->putFileAs(
            'uploads',
            $file,
            $name
        );
        $user = User::find(1);
        // dd($user);
        if ($path) {

            $create = $user->photos()->create([
                'uri' => $path,
                'public' => false,
                'height' => $height,
                'width' => $width
            ]);


            if ($create) {
                return response()->json([
                    'uploaded' => true
                ]);
            }
        }
    }


    public function getPhotos()
    {
        $user = User::find(1);
        // dd($user);
        return response()->json($user->photos->toArray());
    }




    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
