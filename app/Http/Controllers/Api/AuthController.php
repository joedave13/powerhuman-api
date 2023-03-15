<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Resources\AuthResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($request->password);

        $user = User::query()->create($data);

        $token = $user->createToken('token')->plainTextToken;

        return new AuthResource([
            'name' => $user->name,
            'email' => $user->email,
            'token' => $token
        ]);
    }

    public function login(LoginRequest $request)
    {
        if (!auth()->attempt($request->validated())) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = User::query()->where('email', $request->email)->first();

        $token = $user->createToken('token')->plainTextToken;

        return new AuthResource([
            'name' => $user->name,
            'email' => $user->email,
            'token' => $token
        ]);
    }

    public function getUserDetail(Request $request)
    {
        return $request->user();
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->noContent();
    }
}
