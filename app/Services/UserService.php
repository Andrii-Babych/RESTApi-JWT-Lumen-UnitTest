<?php

namespace App\Services;

use App\DataTransferObject\UserData;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserService
{
    /**
     * @param UserData $userData
     * @return string|bool
     */
    public function authentication(UserData $userData): string|bool
    {
        return Auth::attempt(['email' => $userData->email,
            'password' => $userData->password]);
    }

    /**
     * @param UserData $userData
     * @return bool|string
     */
    public function newUserRegistration(UserData $userData): bool|string
    {
        $user = new User();
        $user->setFirstName($userData->first_name);
        $user->setLastName($userData->last_name);
        $user->setEmail($userData->email);
        $user->setPassword($userData->password);
        $user->setPhone($userData->phone);

        try {
            if ($user->save()) {
                // return string | bool
                return Auth::login($user);
            }

            Log::error('Having trouble saving to the database! ', [$userData]);
            return false;

        } catch (\Exception $e) {
            Log::error('There was a problem writing to the database! ', [$e->getMessage()]);
            return false;
        }
    }
}
