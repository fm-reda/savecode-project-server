<?php

namespace App\Http\Controllers;

use DB;
use App\Category;
use App\Custom;
use App\Element;
use App\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CustomController extends Controller
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
    public function firstCreate(Request $request)
    {

        $element = Element::find($request->get('element_id'));

        $category = Auth::User()->categories->where('slug',  Str::slug($request->get('category')))->first();

        if (!$category) {
            $category = Category::create([
                'title' => $request->get('category'),
                'slug' => Str::slug($request->get('category'), '-'),
                'user_id' => Auth::User()->id,
            ]);
        }

        if (!$request->get('subCategory')) {
            // dd('khawi');
            if (!($category->subCategories->where('slug', Str::slug('other'))->first())) {
                // dd('other makaynch');
                $subCategory = SubCategory::create([
                    'title' => 'Other',
                    'slug' => 'other',
                    'category_id' => $category->id,


                ]);
            } else {
                $subCategory = $category->subCategories->where('slug', Str::slug('other'))->first();
                // dd($subCategory);
            }
        } else if (!($category->subCategories->where('slug', Str::slug($request->get('subCategory')))->first())) {
            $subCategory = SubCategory::create([
                'title' => $request->get('subCategory'),
                'slug' => Str::slug($request->get('subCategory'), '-'),
                'category_id' => $category->id,


            ]);
        } else {

            $subCategory = $category->subCategories->where('slug', Str::slug($request->get('subCategory')))->first();
        }

        $custom = Custom::create([
            'title' => $element->title,
            'slug' => Str::slug($element->title, '-'),
            'user_id' => Auth::User()->id,
            'element_id' => $request->get('element_id'),
            'category_id' => $category->id,
            'sub_category_id' => $subCategory->id,
        ]);

        return response()->json([
            'custom' => $custom,
            'category' => $category,
            'subCategory' => $subCategory,
        ], 201);
        // return response()->json(Auth::User(), 200);
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

        $custom = Custom::find($id);



        if (!$custom) {
            return response()->json(['warning' => 'custom data not found'], 205);
        } else {
            $custom->element->first();
            $category = $custom->category->first();
            $subCategory = $custom->subCategory->first();
            $user = $custom->user->first();

            return response()->json(['success' => $custom], 200);
        }


        // dd($request->all());
        // dd($id);
    }
    public function showByCategory(Request $request)
    {
        // return response()->json(['Warning' => Auth::User()], 200);

        $category = Auth::User()->categories->where('slug', $request->get('category'))->first();

        // dd($category);

        if (!$category) {
            // dd('notdound');
            return response()->json(['Warning' => 'Category not found'], 205);
        }
        // $subCategories = $category->subCategories->all();
        // $subCategories = $category->subCategories->where('slug', $request->get('subCategory'))->first();
        $subCategories = $category->subCategories->where('slug', $request->get('subCategory'))->first();

        // $subCategories = $category->subCategories->first();
        // return response()->json($subCategory, 206);

        // dd($subCategories);
        if (!$subCategories) {
            return response()->json(['Warning' => 'Sub-category not found'], 206);
        }

        // dd($subCategories);
        // } else {
        //     dd('null');
        // }
        // dd($subCategories);
        $customs = $subCategories->customs->all();
        if (!$customs) {
            return response()->json(['Warning' => 'Customs not found for this categorizq'], 207);
        }
        // dd($customs);
        // $custom = Custom::find(52);
        // $element = $custom->element->first();
        // $element = Element::find(310);
        // $user = $element->user->first();
        // return response()->json($custom, 200);

        // dd($element);
        foreach ($customs as  $custom) {

            $element = $custom->element->first();
        }
        return response()->json(['success' => $subCategories], 200);
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
        $custom = Custom::find($id);
        if ($custom) {
            $custom->delete();

            return response()->json(['custom' => $custom], 200);
        }


        return response()->json(['custom' => "notFound"], 203);
    }
}
