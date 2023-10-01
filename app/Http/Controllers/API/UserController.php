<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function index(Request $request, User $user)
    {
        $user = auth()->user();

        return response()->json([
            'status'  => 'success',
            'message' => 'GET user success!',
            'data'    => $user,
        ], 200);
    }

    // create
    function store(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string',
            'no_telp'  => 'required|string',
            'username' => 'required|string|unique:users,username',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'no_telp'  => $request->no_telp,
            'username' => $request->username,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'POST user success!',
            'data'    => $user,
        ], 201);
    }

    function searchUsername(Request $request, User $user)
    {
        $user = User::where('username', $request->username)->get()->first();
        if ($user == null) {
            return response()->json([
                'status'   => 'failed',
                'username' => $request->username . ' not found!',
            ], 404);
        } else {
            return response()->json([
                'status'   => 'success',
                'username' => $user->username,
            ], 200);
        }
    }

    function searchEmail(Request $request, User $user)
    {
        $user = User::where('email', $request->email)->get()->first();
        if ($user == null) {
            return response()->json([
                'status' => 'failed',
                'email'  => $request->email . ' not found!',
            ], 404);
        } else {
            return response()->json([
                'status' => 'success',
                'email'  => $user->email,
            ], 200);
        }
    }

    function searchTelepon(Request $request, User $user)
    {
        $user = User::where('no_telp', $request->telepon)->get()->first();
        if ($user == null) {
            return response()->json([
                'status'  => 'failed',
                'no_telp' => $request->telepon . ' not found!',
            ], 404);
        } else {
            return response()->json([
                'status'  => 'success',
                'no_telp' => $user->no_telp,
            ], 200);
        }
    }
}