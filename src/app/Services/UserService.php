<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function checkAuth(array $userData)
    {
        $user = User::where('login', $userData['login'])->first();
        if (!$user || !Hash::check($userData['password'], $user->password)) {
            return null;
        }
        return $user;
    }

    public function addUser(array $userData)
    {
        User::create([
            'login' => $userData['login'],
            'password' => bcrypt($userData['password']),
            'role_id' => Role::GUEST
        ]);
    }

    public function getUsers()
    {
        return User::all();
    }

    public function destroyUsers(array $usersId)
    {
        return User::destroy($usersId);
    }
}
