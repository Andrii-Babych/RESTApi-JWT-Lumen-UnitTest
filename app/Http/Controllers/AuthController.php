<?php

namespace App\Http\Controllers;

use App\DataTransferObject\ResponseData;
use App\DataTransferObject\UserDataRegistration;
use App\DataTransferObject\UserDataLogin;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class AuthController extends Controller
{

    /**
     * @param Request $request
     * @param UserService $userService
     * @return JsonResponse|ResponseData
     * @throws UnknownProperties
     */
    public function login(Request $request, UserService $userService): JsonResponse|ResponseData
    {
        $userData = UserDataLogin::checkingExceptions($request);
        if (!isset($userData->status)) {
            $token = $userService->authentication($userData);

            if (!$token) {
                return new ResponseData([
                    'title' => 'Unauthorized',
                    'detail' => 'Your email or password was entered incorrectly',
                ], 422);
            }

            return $this->respondWithToken($token);
        }
        return $userData;
    }

    /**
     * @param string $token
     * @return JsonResponse
     */
    protected function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    /**
     * @param Request $request
     * @param UserService $userService
     * @return ResponseData|JsonResponse
     * @throws UnknownProperties
     */
    public function register(Request $request, UserService $userService): ResponseData|JsonResponse
    {
        $userData = UserDataRegistration::checkingExceptions($request);
        if (!isset($userData->status)) {
            $token = $userService->newUserRegistration($userData);

            if (!$token) {
                return new ResponseData([
                    'title' => 'Registration problems',
                    'detail' => 'Something went wrong during registration',
                    'status' => 401
                ]);
            }

            return $this->respondWithToken($token);
        }
        return $userData;
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' =>
            'Successfully logged out']);
    }


}
