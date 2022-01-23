<?php declare(strict_types=1);

namespace App\Validator;

use App\Models\User;
use Attribute;
use Spatie\DataTransferObject\Validation\ValidationResult;
use Spatie\DataTransferObject\Validator;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class TokenValidator implements Validator {

    /**
     * @param mixed $value
     * @return ValidationResult
     */
    public function validate(mixed $value): ValidationResult
    {
        if (empty($value)) {
            return ValidationResult::invalid("You must fill in the token field");
        }

        return ValidationResult::valid();
    }
}
