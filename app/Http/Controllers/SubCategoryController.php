<?php

namespace App\Http\Controllers;

use App\Category;
use App\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
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
        // dd('test');
        // return response()->json(['warning:Sub category already exist' => 'test'], 203);

        $category = Auth::User()->categories->where('slug',  Str::slug($request->get('category')))->first();

        if (!$category) {
            $category = Category::create([
                'title' => $request->get('category'),
                'slug' => Str::slug($request->get('category'), '-'),
                'user_id' => Auth::User()->id,
            ]);
        }
        $subCategory = $category->subCategories->where('slug', Str::slug($request->get('subCategory')))->first();
        if (!$subCategory) {
            $subCategory = SubCategory::create([
                'title' => $request->get('subCategory'),
                'slug' => Str::slug($request->get('subCategory'), '-'),
                'category_id' => $category->id,
            ]);
            $category = $subCategory->category->first();
            return response()->json(['success' => $subCategory], 201);
        } else {
            $category = $subCategory->category->first();

            return response()->json(['warning:Sub category already exist' => $subCategory], 203);
        }

        // if (!$request->get('subCategory')) {
        //     // dd('khawi');
        //     if (!($category->subCategories->where('slug', Str::slug('other'))->first())) {
        //         // dd('other makaynch');
        //         $subCategory = SubCategory::create([
        //             'title' => 'Other',
        //             'slug' => 'other',
        //             'category_id' => $category->id,


        //         ]);
        //     } else {
        //         $subCategory = $category->subCategories->where('slug', Str::slug('other'))->first();
        //         // dd($subCategory);
        //     }
        // } else if (!($category->subCategories->where('slug', Str::slug($request->get('subCategory')))->first())) {
        //     $subCategory = SubCategory::create([
        //         'title' => $request->get('subCategory'),
        //         'slug' => Str::slug($request->get('subCategory'), '-'),
        //         'category_id' => $category->id,


        //     ]);
        // } else {

        //     $subCategory = $category->subCategories->where('slug', Str::slug($request->get('subCategory')))->first();
        // }
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
