<?php declare(strict_types=1);

namespace App\DataTransferObject;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use App\Validator\EmailValidator;
use Spatie\DataTransferObject\Exceptions\ValidationException;

class UserData extends DataTransferObject
{
    /**
     * @var string
     */
    #[EmailValidator]
    public string $email;


    /**
     * @throws UnknownProperties
     */
    private static function fromRequest(Request $request): UserData
    {
        return new self(
            email: $request->get('email'),
        );
    }

    /**
     * @param Request $request
     * @return UserDataLogin|ResponseData
     * @throws UnknownProperties
     */
    public static function checkingExceptions(Request $request): UserData|ResponseData
    {
        try {
            return static::fromRequest($request);
        } catch (ValidationException $e) {

            return new ResponseData([
                'title' => 'Unauthorized',
                'detail' => reset($e->validationErrors)[0]->message,
                'status' => 422
            ]);

        } catch (UnknownProperties $e) {
            Log::error('User failed to login. Error', [$e->getMessage()]);
            return new ResponseData([
                'title' => 'Unauthorized',
                'detail' => 'User failed to login',
                'status' => 401
            ]);

        }
    }
}
