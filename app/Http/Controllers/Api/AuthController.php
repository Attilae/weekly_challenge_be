<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create User
     * @param Request $request
     * @return User
     */
    public function createUser(Request $request)
    {
        try {
            //Validated

            $validateUser = Validator::make($request->all(),
            [
                'data.attributes.name' => 'required',
                'data.attributes.email' => 'required|email|unique:users,email',
                'data.attributes.password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'name' => $request['data']['attributes']['name'],
                'email' => $request['data']['attributes']['email'],
                'password' => Hash::make($request['data']['attributes']['password'])
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
            [
                'data.attributes.email' => 'required|email',
                'data.attributes.password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $credentials = [
                'email' => $request['data']['attributes']['email'],
                'password' => $request['data']['attributes']['password'],
            ];

            if(!Auth::attempt($credentials)){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            //dd(Auth::id());
            $request->session()->regenerate();

            $user = User::where('email', $request['data']['attributes']['email'])->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'access_token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function me(Request $request) {
        return response()->json([
            'status' => true,
            'id' => Auth::id()
        ], 200);
    }
}
