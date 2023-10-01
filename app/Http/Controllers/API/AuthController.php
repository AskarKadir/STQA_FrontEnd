<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'username', 'password');
        if (auth()->attempt($credentials)) {
            $user = $request->user();
            if ($user->tokens) {
                $user->tokens()->delete();
            }
            $token = $user->createToken('Personal Access Token')->plainTextToken;
            return response()->json([
                'status'       => 'Login success!',
                'token_type'   => 'Bearer',
                'access_token' => $token,
                'id'           => $user->id,
                'is_admin'     => $user->is_admin,
            ], 201);
        } else {
            return response()->json([
                'status' => 'Login fail!'
            ], 401);
        }
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'status' => 'Logout success!'
        ], 200);
    }

    public function isadmin(Request $request)
    {
        // get isadmin from email or username
        $admin = User::where('email', $request->user)
            ->orWhere('username', $request->user)
            ->first()->is_admin;
        if ($admin == 1) {
            return response()->json([
                'is_admin' => $admin,
            ], 200);
        } else {
            return response()->json([
                'is_admin' => $admin,
            ], 401);
        }
    }
}