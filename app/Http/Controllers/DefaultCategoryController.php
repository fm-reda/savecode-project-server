<?php

namespace App\Http\Controllers;

use App\DefaultCategory;
use Illuminate\Http\Request;

class DefaultCategoryController extends Controller
{
    public function index()
    {
        $defaultCategory=DefaultCategory::all();
        return response()->json(['success' => $defaultCategory], 200);
        
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

}
