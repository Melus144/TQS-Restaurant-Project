<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Authentication
 *
 * Endpoints for authentication management
 */
class AuthController extends Controller
{
    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'errors' => ['password' => ['The introduced password is incorrect.']]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $token = $user->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'data' => ['token' => $token]
        ]);
    }

    public function register(RegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($request->validated()['password']);
        $validated['role'] = $request->has('role') ? $request->get('role') : User::WORKER;

        $user = User::create($validated);

        return UserResource::make($user)->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'data' => ['message' => 'Tokens have been revoked.']
        ]);
    }
}
