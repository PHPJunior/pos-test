<?php

namespace Domain\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Domain\Auth\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use OpenApi\Annotations as OA;

class AuthApiController extends Controller
{
    /**
     * Handle an incoming authentication request.
     *
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Auth"},
     *     summary="Authenticate a user",
     *     description="Authenticate a user",
     *     operationId="login",
     *     @OA\RequestBody( description="User credentials", required=true,
     *         @OA\JsonContent( required={"email","password"},
     *            @OA\Property(property="email", type="string", format="email", example="user@user.com"),
     *            @OA\Property(property="password", type="string", format="password", example="password")
     *         ),
     *     ),
     *     @OA\Response(  response=200, description="User authenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="token"),
     *             @OA\Property(property="user", type="object")
     *        )
     *    )
     * )
     *
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $request->authenticate();

        $token = $request->user()->createToken('authToken')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $request->user(),
        ]);
    }
}
