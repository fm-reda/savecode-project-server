<?php

namespace App\Http\Controllers;

use App\DefaultCategory;
use App\Element;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ElementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        // dd('create');

        // $default_category = DefaultCategory::where('title', $request->get('default_category_title'))->first();
        if ($request->get('default_category_title')) {
            $default_category = DefaultCategory::where('slug', Str::slug($request->get('default_category_title')))->first();
            if (!$default_category) {
                $default_category = DefaultCategory::where('title', 'other')->first();
                // dd($default_category->id);

            }
            // dd($default_cat  egory->id);
        } else {

            // dd('id');


            $default_category = DefaultCategory::find($request->get('default_category_id'));
            // $default_category = DefaultCategory::find(5);
            // return response()->json(['success' =>  $default_category], 201);
            if (!$default_category) {
                $default_category = DefaultCategory::where('title', 'other')->first();
                // dd($default_category->id);

            }
        }
        // dd($default_category->id);

        $element = Element::create([
            'title' => $request->get('title'),
            'slug' => Str::slug($request->get('title'), '-'),
            'description' => $request->get('description'),
            'code' => $request->get('code'),
            'user_id' => Auth::User()->id,
            'default_category_id' => $default_category->id,


        ]);
        $elements = $default_category->elements->all();
        // dd($elements);
        $defaultCategory = $element->defaultCategory->get();

        return response()->json(['success' => $element], 201);
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
