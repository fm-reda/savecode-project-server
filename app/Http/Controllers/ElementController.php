<?php

namespace App\Http\Controllers;

use App\Category;
use App\Custom;
use App\DefaultCategory;
use App\Element;
use App\User;
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
        // dd('test');
        $user = Auth::User();
        // dd($user);

        $countElement = Element::All()->count();
        $countUser = User::All()->count();
        // $countCustom = Custom::All()->count();
        $countCustom = $user->customs->count();

        $countCategory = $user->categories->count();
        // dd($countCustom);
        $elements = Element::latest()->take(3)->get();
        foreach ($elements as  $element) {
            # code...
            $element->user->get();
            $element->defaultCategory->get();
        }
        $customs = $user->customs->take(3)->all();
        foreach ($customs as  $custom) {
            # code...
            $custom->element->get();
            $custom->category->get();
        }
        $elementsUser = $user->elements->take(3)->all();
        foreach ($elementsUser as  $elementUser) {
            # code...
            $elementUser->defaultCategory->get();
            // $custom->category->get();
        }
        // dd($customs);



        return response()->json([
            'elements' => $elements,
            'elementsUser' => $elementsUser,
            'customs' => $customs,
            'countUser' => $countUser,
            'countElement' => $countElement,
            'countCustom' => $countCustom,
            'countCategory' => $countCategory
        ], 200);
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
        $element = Element::find($id);
        $defaultCatgeory = $element->defaultCategory->get();
        $user = $element->user->get();

        // $element = Element::find($id);
        // $custom = Custom::find($id);
        $custom = Custom::where('element_id', $id)
            ->where('user_id', Auth::User()->id)
            ->first();
        // return response()->json(['success' => $element], 200);
        // dd($custom);
        // return response()->json(['warning' => $custom], 205);




        if (!$custom) {
            return response()->json(['element' => $element], 200);
        } else {
            // $element = $custom->element->first();
            $category = $custom->category->first();
            // dd($custom);
            $subCategory = $custom->subCategory->first();
            $user = $custom->user->first();

            return response()->json(['element' => $element, 'custom' => $custom], 200);
        }
    }

    public function showByTitle(Request $request)
    {
        // return response()->json(['success' => $request->get('word')], 200);
        // return response()->json(['success' => "rrrr"], 200);

        $search = $request->get('word');
        $slugSearch = Str::slug($search);
        // dd($slugSearch);

        // $element = Element::where('slug', 'like', '%(Str::slug($request->get('title')))%')->get();
        $elements = Element::where('slug', 'like', "%$slugSearch%")->latest()->get();
        foreach ($elements as $element) {
            $user = $element->user->get();
            $default_category = $element->defaultCategory->get();
            $custom = $element->customs->all();
            // return response()->json(['data'=>$custom],200);
            # code...
        }
        // $element = Element::where('slug', 'like', "%javascript%")->get();
        return response()->json(['elements' => $elements], 200);

        // $element = Element::find($id);
        // $defaultCatgeory = $element->defaultCategory->get();
        // $user = $element->user->get();

        // // $element = Element::find($id);
        // // $custom = Custom::find($id);
        // $custom = Custom::where('element_id', $id)->first();
        // // return response()->json(['success' => $element], 200);
        // // dd($custom);
        // // return response()->json(['warning' => $custom], 205);




        // if (!$custom) {
        //     return response()->json(['element' => $element], 200);
        // } else {
        //     // $element = $custom->element->first();
        //     $category = $custom->category->first();
        //     // dd($custom);
        //     $subCategory = $custom->subCategory->first();
        //     $user = $custom->user->first();

        //     return response()->json(['element' => $element, 'custom' => $custom], 200);
        // }
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

        // $element = Element::find(3);
        // dd($element);
        // $custom = $element->custom->first();
        // dd($custom);
    
        // $element = Element::find($id);
        // $user = $element->user->first();
    
        // dd($user);
    
        // $custom = $element->custom->first();
        // // dd($custom);
        // $category = $custom->category->first();
        // $subCategory = $custom->subCategory->first();
        // $user = $custom->user->first();
        // return response()->json(['element' => $element, 'custom' => $custom], 200);
    
    
    
        // if (!$custom) {
        //     return response()->json(['warning' => 'custom data not found'], 205);
        // } else {
        //     $element = $custom->element->first();
        //     $category = $custom->category->first();
        //     $subCategory = $custom->subCategory->first();
        //     $user = $custom->user->first();
    
        //     return response()->json(['success' => $custom], 200);
        // }
