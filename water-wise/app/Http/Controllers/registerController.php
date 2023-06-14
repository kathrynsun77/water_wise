<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class registerController extends Controller
{
    public function register(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        // Return validation errors if validation fails
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Create a new user
        $user = User::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'password' =>$request->password,//jgn lupa bycript nanti
            'user_type' =>3,
            'user_status' =>1,
            'mobile'=>0,
            'gender'=>'-',
            'uname'=>'-'
        ]);

        // Return a success response
        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
        ], 201);
    }

}
