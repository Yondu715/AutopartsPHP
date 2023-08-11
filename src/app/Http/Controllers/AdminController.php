<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApplicationResource;
use App\Http\Resources\UserResource;
use App\Services\ApplicationService;
use App\Services\UserService;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    private UserService $userService;
    private ApplicationService $applicationService;

    public function __construct(UserService $userService, ApplicationService $applicationService)
    {
        $this->userService = $userService;
        $this->applicationService = $applicationService;
    }

    public function indexApplications()
    {
        $applications = $this->applicationService->getApplications();
        return ApplicationResource::collection($applications);
    }

    public function acceptApplications(Request $request)
    {
        $userId = $request->user_id;
        $roleId = $request->role_id;
        $this->applicationService->acceptApplication($userId, $roleId);
        return response()->json([
            'message' => 'Заявки были успешно приняты'
        ], 200);
    }

    public function deleteAplications(int $userId)
    {
        $this->applicationService->deleteApplication($userId);
        return response()->json([
            'message' => 'Заявки были успешно удалены'
        ], 204);
    }

    public function indexUsers()
    {
        $users = $this->userService->getUsers();
        return UserResource::collection($users);
    }

    public function destroyUsers(Request $request)
    {
        $usersIdString = $request->header('usersId');
        $usersId = json_decode($usersIdString);
        $this->userService->destroyUsers($usersId);
        return response()->json([
            'message' => 'Пользователи были успешно удалены'
        ], 200);
    }
}
