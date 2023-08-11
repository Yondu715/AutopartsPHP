<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;

class ApplicationService {

    public function getApplications()
    {
        $applications = User::where('role_id', Role::GUEST)->get();
        return $applications;
    }

    public function acceptApplication(int $userId, int $roleId)
    {
        if ($roleId !== Role::GUEST){
            User::where('id', $userId)->update(['role_id' => $roleId]);
        }
    }

    public function deleteApplication(int $userId)
    {
        $user = User::find($userId);
        if ($user->role->id === Role::GUEST){
            User::destroy($userId);
        }
    }
}