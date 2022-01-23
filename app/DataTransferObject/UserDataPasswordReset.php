<?php declare(strict_types=1);

namespace App\DataTransferObject;

use App\Validator\TokenValidator;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use App\Validator\PasswordValidator;

class UserDataPasswordReset extends UserData
{
    /**
     * @var string
     */
    #[PasswordValidator(7, 30)]
    public string $password;

    /**
     * @var string
     */
    #[TokenValidator]
    public string $token;

    /**
     * @param Request $request
     * @return UserDataLogin
     * @throws UnknownProperties
     */
    protected static function fromRequest(Request $request): UserData
    {
        return new self(
            email: $request->get('email'),
            password: $request->get('password'),
            token: $request->get('token'),
        );
    }
}
