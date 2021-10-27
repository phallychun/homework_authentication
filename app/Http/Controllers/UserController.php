<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function regiester(Request $request){
        $request->validate([
            'password'=> 'required | confirmed', // need to confirmed password
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $token = $user->createToken('mytoken')->plainTextToken; // create token for user login one user has only token for request info to login

        return response()->json([
            'user'=>$user,
            'token'=>$token,
           
        ]);
        
    }
    

    // login user public function
    public function login(Request $request){
            
        $user = User::where('email', $request->email)->first(); // to get the email that max with user singup havin store
        
        // Chek if the email of user and password is invalid 
        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json(["message" => "Your login is doesn't max"], 401);
        }

        // create token for user login one user has only token for request info to login
        $token = $user->createToken('mytoken')->plainTextToken; 
        return response()->json([
            'user'=>$user,
            'token'=>$token,
           
        ]);
    }

    // signout user public functio
    public function logout(Request $request){
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'Logout']);
    }

    // show all users public function
    public function index(Request $request){
        return User::get();
    }

    // show specified user public function
    public function show(Request $request, $id){
        return User::findOrFail($id);
    }
}
