<?php declare(strict_types=1);

namespace App\Validator;

use Attribute;
use Spatie\DataTransferObject\Validation\ValidationResult;
use Spatie\DataTransferObject\Validator;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class PhoneValidator implements Validator {

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
            return ValidationResult::invalid("You must fill in phone");
        }

        if (strlen((string)$value) < $this->min) {
            return ValidationResult::invalid("Phone should be min {$this->min} characters");
        }

        if (strlen((string)$value) > $this->max) {
            return ValidationResult::invalid("Phone must be no more than {$this->max} characters");
        }

        return ValidationResult::valid();
    }
}
