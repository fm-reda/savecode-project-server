<?php

namespace App\Http\Controllers;

use App\User;
use App\Category;
use App\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::User();
        $categories = $user->categories->all();
        // $categories = Category::find(102);
        // dd($categories);

        // $subCategories = $categories->subCategories->all();
        foreach ($categories as  $category) {

            $subCategories = $category->subCategories->all();
            // dd($subCategories);
        }
        // return response()->json(['success' => $categories], 200);
        // return response()->json(['success' => $subCategories], 200);
        return response()->json(['success' => $user], 200);


        // $categories = Category::all();

        // dd($categories);
        $subCategories = $categories->subCategories->get();
        return response()->json(['success' => $categories], 200);


        // dd($categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    { }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd('test');

        $category = Auth::User()->categories->where('slug',  Str::slug($request->get('category')))->first();
        // $category = Auth::User()->categories->where('slug',  'laravel')->first();
        // return response()->json(['warning : Category already exist' => $request->get('category')], 203);
        // return response()->json(['warning : Category already exist' =>  $category], 203);

        if (!$category) {
            $category = Category::create([
                'title' => $request->get('category'),
                'slug' => Str::slug($request->get('category'), '-'),
                'user_id' => Auth::User()->id,
            ]);
            return response()->json(['success' => $category], 201);
        } else {
            return response()->json(['warning : Category already exist' => $category], 203);
        }
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
