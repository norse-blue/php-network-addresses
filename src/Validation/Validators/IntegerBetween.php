<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\Validation\Validators;

use Attribute;
use NorseBlue\NetworkAddresses\Validation\ValidationResult;
use NorseBlue\NetworkAddresses\Validator;

#[Attribute(Attribute::TARGET_PROPERTY)]
class IntegerBetween implements Validator
{
    public function __construct(private int $min, private int $max)
    {
    }

    public function validate(mixed $value): ValidationResult
    {
        if (! is_int($value)) {
            return ValidationResult::invalid("Value should be an integer.");
        }

        if ($value < $this->min) {
            return ValidationResult::invalid("Value should be greater than or equal to $this->min.");
        }

        if ($value > $this->max) {
            return ValidationResult::invalid("Value should be less than or equal to $this->max.");
        }

        return ValidationResult::valid();
    }
}
