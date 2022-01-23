<?php declare(strict_types=1);

namespace App\DataTransferObject;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use App\Validator\EmailValidator;
use App\Validator\FirstNameValidator;
use App\Validator\LastNameValidator;
use App\Validator\PhoneValidator;

class UserDataRegistration extends UserDataLogin
{
    /**
     * @var string
     */
    #[FirstNameValidator(2, 100)]
    public string $first_name;

    /**
     * @var string
     */
    #[LastNameValidator(2, 100)]
    public string $last_name;

    /**
     * @var string
     */
    #[EmailValidator(true)]
    public string $email;

    /**
     * @var int
     */
    #[PhoneValidator(9, 30)]
    public int $phone;

    /**
     * @param Request $request
     * @return UserDataLogin
     * @throws UnknownProperties
     */
    protected static function fromRequest(Request $request): UserData
    {
        return new self(
            first_name: $request->get('first_name'),
            last_name: $request->get('last_name'),
            email: $request->get('email'),
            password: $request->get('password'),
            phone: self::getNumber($request->get('phone')),
        );
    }

    /**
     * @param string $str
     * @return int
     */
   private static function getNumber(string $str): int
   {
       return (int)preg_replace("/[^,.0-9]/", '', $str);
   }
}
