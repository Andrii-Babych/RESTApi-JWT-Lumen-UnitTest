<?php

namespace App\Http\Controllers;

use App\DataTransferObject\ResponseData;
use App\DataTransferObject\UserData;
use App\DataTransferObject\UserDataPasswordReset;
use Illuminate\Auth\Passwords\PasswordBrokerManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Contracts\Auth\PasswordBroker;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;


class ResetsPasswordsController extends Controller
{
    /**
     * @param Request $request
     * @return ResponseData
     * @throws UnknownProperties
     */
    public function generateResetToken(Request $request): ResponseData
    {
        $userData = UserData::checkingExceptions($request);
        if (!isset($userData->status)) {

            try {
                $response = $this->broker()
                    ->sendResetLink(['email'=>$userData->email]);

            } catch (\Exception $e) {

                return new ResponseData([
                    'title' => 'Error',
                    'detail' => $e->getMessage(),
                ], 422);
            }

            if ($response == Password::RESET_LINK_SENT) {

                return new ResponseData([
                    'title' => 'Successfully',
                    'detail' => 'The letter was sent to the email address',
                ]);
            } else {

                return new ResponseData([
                    'title' => 'Error',
                    'detail' => 'The letter was not sent',
                ], 401);
            }
        }

        return $userData;
    }

    /**
     * @param Request $request
     * @return ResponseData
     * @throws UnknownProperties
     */
    public function resetPassword(Request $request): ResponseData
    {
        if ($request->isMethod('patch')) {

            $userData = UserDataPasswordReset::checkingExceptions($request);
            if (!isset($userData->status)) {

                $response = $this->broker()->reset(
                    $this->credentials($userData),
                    function ($user, $password) {
                        $user->password = app('hash')->make($password);
                        $user->save();
                    });

                   if ($response == Password::PASSWORD_RESET) {

                       return new ResponseData([
                           'title' => 'Successfully',
                           'detail' => 'Password has been successfully changed',
                       ]);
                   } else {

                       return new ResponseData([
                           'title' => 'Error',
                           'detail' => 'Having trouble changing your password',
                       ], 401);
                   }
            }

            return $userData;
        }

        return new ResponseData([
            'title' => 'Error',
            'detail' => 'wrong method',
        ], 401);
    }

    /**
     * @param UserData $userData
     * @return array
     */
    protected function credentials(UserData $userData): array
    {
        return [
            'email' => $userData->email,
            'password' => $userData->password,
            'token' => $userData->token
            ];
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return PasswordBroker
     */
    public
    function broker(): PasswordBroker
    {
        $passwordBrokerManager = new PasswordBrokerManager(app());
        return $passwordBrokerManager->broker();
    }

}
