<?php declare(strict_types=1);

namespace App\DataTransferObject;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use App\Validator\PasswordValidator;

class UserDataLogin extends UserData
{
    /**
     * @var string
     */
    #[PasswordValidator(7, 30)]
    public string $password;

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
            );
    }
}
