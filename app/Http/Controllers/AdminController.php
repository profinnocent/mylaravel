<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admins;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
        // ============================================================================
    // ============================================================================
    // Admin Rotue : USER modificaion route
    // ============================================================================
    // ============================================================================
   
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUsers()
    {
        return response()->json(['Users'=>User::all()]);
    }

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getOneUser($id)
    {
        $user = User::find($id);
        if($user) 
        return response()->json(['user'=>$user], 200);

        return response()->json(['message'=>'user not found',
                                'status'=>false], 200);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createUser(Request $request)
    {
        // print_r($request->all);
        return response(['User'=>User::create($request->all()), 'statuscode'=>200]);
    }


 
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateUser(Request $request, $id)
    {

        $user = User::find($id);

        if($user){

            if($user->update($request->all())){
                return response()->json([
                    'msg'=>'User updated successfully.',
                    'status'=>true
                ], 200);
            }

            return response()->json([
                'msg'=>'Failed to update user. Try again.',
                'status'=>false
            ], 400);

        }

        return response(['message'=> 'user not found', 'statuscode' => 401]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteUser($id)
    {

        return User::destroy($id);

    }

    public function deleteUser2(Request $request){

        $user = $this->getUser($request);

        $user->delete();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function searchUsers($name)
    {

        return User::where('name', 'like', '%'. $name .'%')->get();

    }


    // =================================================================================
    // Admin Area
    // ==================================================================================

      /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createAdmin(Request $request)
    {

        return response(['message'=>'This action is not available for now']);

        // $validated = $request->validate(['name'=>'required|string',
        //                                  'email'=>'required|string|unique:admins,email',
        //                                  'password'=>'required|string']);

        // $name = $validated['name'];
        // $email = $validated['email'];
        // $password = Hash::make($validated['password']);


        // return response(['Admin'=>Admins::create([
        //                 'name'=>$name,
        //                 'email'=>$email,
        //                 'password'=>$password
        //                  ]), 200]);

    }


    public function adminlogout(Request $request)
    {

        // delete all tokens, essentially logging the user out
        // $user->tokens()->delete();

        // delete the current token that was used for the request
        $request->user()->currentAccessToken()->delete();

        // $this->getUser($request)->currentAccessToken->delete();


        return response(['message' => 'Admin Logged Out', 'statuscode'=>200]);
    }



    // ============================================
    // Login handler
    // ===========================================
    public function adminlogin(Request $request)
    {

        $userdata = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $adminuser = Admins::where('email', $userdata['email'])->first();


        // Hnadle registration error
        if ($adminuser && Hash::check($userdata['password'], $adminuser->password)) {

            // Generate token
            $token = $adminuser->createToken('newusertoken')->plainTextToken;

            return response([
                'msg'=>'Admin logged in succesfully',
                'user' => $adminuser,
                'token' => $token,
                'statuscode' => 200
            ]);

        } else {
            
            return response(['message' => 'Wrong email or password.', 'statuscode' => 401]);

        }
    }


    public function getCurrentAdmin(Request $request)
    {
        return $request->user();
    }



}
