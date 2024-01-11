<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    //Log in
    public function login(Request $request)
    {
        $request->validate([
            'email'       => 'required|email',
            'password'    => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(["message" => "Invalid username and password provided"], 404);
        }

        $token = $user->createToken($request->email)->plainTextToken;
        // return $token;

        $response = [
            "status" => 200,
            "user"  => $user,
            "token" => $token,
            "message" => "Loged in Sucessfully."

        ];

        return response()->json($response, 200);
    }
}
