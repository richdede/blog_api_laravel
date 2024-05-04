<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Login method
     */

     public function login(LoginRequest $request)
     {
        $token = auth()->attempt($request->validated());
        if ($token) {
            return $this->responseWithToken($token, auth()->user());
        } else {
            return response()->json(
                [
                    'status' => 'failed',
                    'message' => 'Invalid Credentials',
                ],
                401
            );
        }
     }

     /**
      * Registration method
      */

      public function register(RegistrationRequest $request)
      {
        $user = User::create($request->validated());
        if ($user) {
            $token = auth()->login($user);
            return $this->responseWithToken($token, $user);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'An error occurred while creating user',
            ], 500);
        }

      }

          /**
     * Return jwt access token
     */

    public function responseWithToken($token, $user)
    {
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'bearer',
        ]);
    }


    /**
     * Get all user
     */

     public function getUserById($id)
     {
         $user = User::find($id);
 
         if (!$user) {
             return response()->json(['message' => 'User not found'], 404);
         }
 
         return response()->json(['user' => $user]);
     }
}
