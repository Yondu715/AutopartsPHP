<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegistrRequest;
use App\Services\UserService;

class AuthController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function auth(AuthRequest $request)
    {
        $data = $request->validated();
        $user = $this->userService->checkAuth($data);
        if (!$user) {
            return response()->json([
                'message' => 'Пользователь не найден'
            ], 401);
        };
        $token = $user->createToken('auth')->plainTextToken;
        return response()->json([
            'data' => [
                'token' => $token,
                'user' => $user,
            ],
            'message' => 'Пользователь успешно авторизован'
        ], 200);
    }

    public function registr(RegistrRequest $request)
    {
        $data = $request->validated();
        try {
            $this->userService->addUser($data);
            return response()->json([
                'message' => 'Заявка на регистрацию успешно отправлена'
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'message' => 'Заявка на регистрацию была отклонена'
            ], 409);
        }
    }
}
