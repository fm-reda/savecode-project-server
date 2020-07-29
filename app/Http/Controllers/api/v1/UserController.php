<?php

namespace App\Http\Controllers\api\v1;

use App\Category;
use App\DefaultCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public $successStatus = 200;
    public $unauthorisedStatus = 401;
    public $createdStatus = 201;

    public function login()

    {


        // dd(request('email'));
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            // dd(Auth::user());
            $user = Auth::user();
            // dd($user);
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $response = [
                'user' => Auth::User(),
                'access_token' => $success['token']
            ];
            return response()->json($response, $this->successStatus);
        } else {
            return response()->json(['status' => $this->unauthorisedStatus, 'error' => 'Invalid credentials'], $this->unauthorisedStatus);
        }
    }
    public function register(Request $request)
    {



        // dd($category);
        $userEmail = User::where('email', $request->get('email'))->first();

        if ($userEmail) {
            return response()->json(['Email already exist' => $userEmail], 208);
        }
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        // dd($request->get('email'));

        // dd(User::where('email', $request->get('email'))->get());
        $input = $request->all();
        // dd($input);
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $user->avatar = "default.png";
        $user->save();
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        // dd($success['token']);
        $success['name'] =  $user->name;
        $success['email'] =  $user->email;


        $defaultCategories = DefaultCategory::all();
        foreach ($defaultCategories as  $defaultCategory) {
            $category = Category::create([
                'title' => $defaultCategory->title,
                'slug' => $defaultCategory->slug,
                'user_id' => $user->id,
                // 'user_id'=>$defaultCategory->title,
            ]);
        }
        return response()->json(['success' => $user], $this->createdStatus);
    }
    public function details()

    {
        // dd(User::All());


        $users = Auth::user();
        return response()->json(['success' => $users], $this->successStatus);
    }
    public function uploadAvatar(Request $request)

    {
        // $user = Auth::User();
        // dd(User::All());


        $user = Auth::user();
        $file = $request->file('file');
        // dd($file);
        if (!$file) {

            return response()->json(['warning' => 'file empty'], 200);
        } else {
            $ext = $file->extension();
            $name = Carbon::now()->format('d-m-Y') . '-' . Str::random(10) . '.' . $ext;
            $path = Storage::disk('public')->putFileAs('users', $file, $name);
            $user->avatar = $name;
            $user->save();





            return response()->json(['user' => $user], 200);
        }
    }
    public function updateUser(Request $request)

    {
        // $user = Auth::User();
        // dd(User::All());


        $user = Auth::user();
        // return response()->json(['user' => $user], 200);

        $checkEmail = User::where('email', $request->get('email'))->first();
        // return response()->json(['user' => $checkEmail], 200);


        if ($checkEmail && $checkEmail->id != $user->id) {
            return response()->json(['Email already exist' => $checkEmail], 208);
        }
        $user->name = $request->get('name');
        $user->email = $request->get('email');

        // dd($file);

        // $user->avatar = $name;
        $user->save();





        return response()->json(['user' => $user], 200);
    }
}







    // public function searchByName($name)
    // {
    //     // dd($id);
    //     $user = User::where('email', $name)->firstOrFail();


    //     // if (!$user) {
    //     //     return response()->json(['error' => "user introuvable"], 401);
    //     // }
    //     return response()->json($user, 200);
    // }
    // public function logout()
    // {

    //     $user = Auth::logout();
    //     return response()->json(['success' => $user, 'message' => "user successefully logout"], $this->successStatus);
    // }
