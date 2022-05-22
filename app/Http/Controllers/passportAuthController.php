<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class passportAuthController extends Controller
{
    /**
     * handle user registration request
     */
    public function registerUser(Request $request){
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:8',
        ]);
        $user= User::create([
            'name' =>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
        ]);

        $access_token = $user->createToken('authToken')->accessToken;
        //return the access token we generated in the above step
        return response()->json(['user'=>$user,'token'=>$access_token],200);
        // return ["success"=>"user deleted successfully"];
    }

    /**
     * login user to our application
     */
    public function loginUser(Request $request){
        $login_credentials=[
            'email'=>$request->email,
            'password'=>$request->password,
        ];
        if(!Auth::attempt($login_credentials)){
            return response()->json(['error'=>"Login Credentials incorrect"]);
        }
        $user_login_token=Auth::user()->createToken('authToken')->accessToken;
        return response()->json(['user'=>Auth::user(),'token'=>$user_login_token]);
    }

    /**
     * This method returns authenticated user details
     */
    // public function authenticatedUserDetails(){
    //     //returns details
    //     return response()->json(['authenticated-user' => ], 200);
    // }
}

