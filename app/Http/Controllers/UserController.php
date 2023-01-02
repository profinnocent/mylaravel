<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    // ============================================
    // Register handler
    // ===========================================
    public function register(Request $request)
    {

        $userdata = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users,email',
            'password' => 'required|string'
        ]);

        $new_user = User::create([
            'name' => $userdata['name'],
            'email' => $userdata['email'],
            'password' => bcrypt($userdata['password'])
        ]);

        // Hnadle registration error
        if ($new_user) {

            return response(['statuscode'=>201], 201);

        } else {

            return response(['message' => 'New User registration failed due to bad request or user email already exists.'], 400);
        }
    }



    // ============================================
    // Logout handler
    // ===========================================
    public function logout(Request $request)
    {

        // delete all tokens, essentially logging the user out
        // $user->tokens()->delete();

        // delete the current token that was used for the request
        $request->user()->currentAccessToken()->delete();

        // $this->getUser($request)->currentAccessToken->delete();


        return response(['message' => 'Logged Out', 'statuscode'=>200]);
    }



    // ============================================
    // Login handler
    // ===========================================
    public function login(Request $request)
    {

        $userdata = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $userdata['email'])->first();


        // Hnadle registration error
        if ($user && Hash::check($userdata['password'], $user->password)) {

            // Generate token
            $token = $user->createToken('newusertoken')->plainTextToken;

            return response([
                'user' => $user,
                'token' => $token,
                'statuscode' => 200
            ]);

        } else {
            
            return response(['message' => 'Wrong email or password.', 'statuscode' => 401]);

        }
    }


    // ============================================
    // Get User handler
    // ===========================================
    public function getCurrentUser(Request $request)
    {
        return $request->user();
    }

}
