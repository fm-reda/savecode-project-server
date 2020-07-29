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

            $number = $category->count();

            $subCategories = $category->subCategories->all();
            foreach ($subCategories as  $subCategory) {



                $customs = $subCategory->customs->count();
                // $number = $customs->count();
                // return response()->json(['success' => $customs], 200);
            }
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
    public function singleCategories(Request $request)
    {
        $user = Auth::User();
        $category = Auth::User()->categories->where('slug',  Str::slug($request->get('category')))->first();
        $subCategory = $category->subCategories->where('slug',  Str::slug($request->get('subCategory')))->first();
        // $user=User::find(2);
        return response()->json([
            'category' => $category, 'subCategory' => $subCategory
        ], 200);

        dd($user);
        $categories = Category::get();
        dd($categories);
        $categories = $user->categories->all();
    }

    public function updateCategories(Request $request)

    {
        $user = Auth::User();
        //  return response()->json(['success' => $user], 201);
        // dd(User::All());



        // $user = Auth::user();
        $categoryUpdate = Category::find($request->get('category_id'));
        $subCategoryUpdate = SubCategory::find($request->get('sub_category_id'));
        $category = Auth::User()->categories->where('slug',  Str::slug($request->get('category')))->first();
        $subCategory = Category::find($request->get('category_id'))->subCategories
            ->where('slug',  Str::slug($request->get('subCategory')))->first();
        if ($category && $category->slug != $categoryUpdate->slug) {
            return response()->json(['category' => Str::slug($request->get('category'))], 203);
        } else {

            $categoryUpdate->title = $request->get('category');
            $categoryUpdate->slug =  Str::slug($request->get('category'));
            $categoryUpdate->save();
        }

        if ($subCategory && $subCategory->slug != $subCategoryUpdate->slug) {

            // return response()->json(['subCategory' => $category], 206);
            return response()->json(['subCategory' => Str::slug($request->get('subCategory'))], 206);
        } else {
            $subCategoryUpdate->title = $request->get('subCategory');
            $subCategoryUpdate->slug =  Str::slug($request->get('subCategory'));
            $subCategoryUpdate->save();
        }


        return response()->json(['category' => $categoryUpdate, 'subCategory' => $subCategoryUpdate], 200);

        // return response()->json(['user' => $user], 200);

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
