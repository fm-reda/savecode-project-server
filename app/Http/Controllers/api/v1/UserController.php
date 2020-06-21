<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public $successStatus = 200;
    public $unauthorisedStatus = 401;

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
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        // dd($success['token']);
        $success['name'] =  $user->name;
        return response()->json(['success' => $success], $this->successStatus);
    }
    public function details()

    {
        // dd(User::All());


        $users = Auth::user();
        return response()->json(['success' => $users], $this->successStatus);
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
}
