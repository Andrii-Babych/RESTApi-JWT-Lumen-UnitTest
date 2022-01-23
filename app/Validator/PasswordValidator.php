<?php declare(strict_types=1);

namespace App\Validator;

use Attribute;
use Spatie\DataTransferObject\Validation\ValidationResult;
use Spatie\DataTransferObject\Validator;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class PasswordValidator implements Validator {

    /**
     * @param int $min
     * @param int $max
     */
    public function __construct(
        private int $min,
        private int $max ) {

    }

    /**
     * @param mixed $value
     * @return ValidationResult
     */
    public function validate(mixed $value): ValidationResult
    {
        if (empty($value)) {
            return ValidationResult::invalid("The password field cannot be empty");
        }

        if (strlen($value) < $this->min) {
            return ValidationResult::invalid("Password must be at least {$this->min} characters");
        }

        if (strlen($value) > $this->max) {
            return ValidationResult::invalid("Password must be no more than {$this->max} characters");
        }

        return ValidationResult::valid();
    }
}
