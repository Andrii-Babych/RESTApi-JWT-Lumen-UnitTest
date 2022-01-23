<?php declare(strict_types=1);

namespace App\Validator;

use App\Models\User;
use Attribute;
use Spatie\DataTransferObject\Validation\ValidationResult;
use Spatie\DataTransferObject\Validator;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class EmailValidator implements Validator {

    /**
     * @param bool $exists
     */
    public function __construct(private bool $exists = false) {}

    /**
     * @param mixed $value
     * @return ValidationResult
     */
    public function validate(mixed $value): ValidationResult
    {
        if (empty($value)) {
            return ValidationResult::invalid("You must fill in the email field");
        }

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return ValidationResult::invalid("Email address {$value} is considered valid");
        }

        if ($this->exists && User::where('email', '=', $value)->exists()) {
            return ValidationResult::invalid("User already exists with this email");
        }

        return ValidationResult::valid();
    }
}
