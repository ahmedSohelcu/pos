<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => ['required','email'],
                'password' => ['required']
            ]);
            
            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'message' => 'Invalid credentials'
                ], 401);
            }           

            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            
            return response()->json([
                'message' => 'Logged In Successfully',
                'user' => $user,
                'token' => $token
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function logout(Request $request)
    {
        // $request->user()->currentAccessToken()->delete(); //to delete from current device
        $request->user()->tokens()->delete();//to delete from all devices

        return response()->json([
            'message' => 'Logged Out Successfully from All Devices'
        ]);
    }
}
