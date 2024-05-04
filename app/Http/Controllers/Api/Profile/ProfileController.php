<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{


    /**
     * Update user method
     */
    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            // Update user attributes
            if ($request->has('username')) {
                $user->username = $request->username;
            }
            if ($request->has('email')) {
                $user->email = $request->email;
            }
            if ($request->has('password')) {
                $user->password = Hash::make($request->password);
            }
            if ($request->has('profilePic')) {
                $user->profilePic = $request->profilePic;
            }

            if ($user->save()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'User updated successfully',
                    'user' => $user
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Failed to update user',
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User not found',
            ], 404);
        }
    }

    /**
     * Delete user
     */

     public function delete($id)
     {
         try {
             $user = User::findOrFail($id);
 
             if ($user->delete()) {
                 return response()->json([
                     'status' => 'success',
                     'message' => 'User deleted successfully',
                 ], 200);
             } else {
                 return response()->json([
                     'status' => 'failed',
                     'message' => 'Failed to delete user',
                 ], 500);
             }
         } catch (\Exception $e) {
             return response()->json([
                 'status' => 'failed',
                 'message' => 'User not found',
             ], 404);
         }
     }

     /**
      * GetuserbyId method
      */

      
    public function getUserById($id)
    {
        try {
            $user = User::findOrFail($id);

            return response()->json([
                'status' => 'success',
                'user' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User not found',
            ], 404);
        }
    }
}
