<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
class AuthController extends Controller
{
    public function register(RegisterRequest $request)
{
    $user = User::create([
    'name' => $request->name,
    'username' => $request->username,
    'email' => $request->email,
    'password' => $request->password,
]);
$token = $user->createToken('auth_token')->plainTextToken;
return response()->json([
    'user' => $user,
    'token' => $token,
]);

}

public function login(LoginRequest $request)
{
    $user = User::where('email', $request->email)->first();
    if (!$user || !Hash::check($request->password, $user->password)) {
    return response()->json([
        'message' => 'Invalid credentials'
    ], 401);
}
$token = $user->createToken('auth_token')->plainTextToken;
return response()->json([
    'user' => $user,
    'token' => $token,
]);

}
public function logout(Request $request)
{
    $request->user()->currentAccessToken()->delete();
    return response()->json([
    'message' => 'Logged out successfully'
]);

}
}
