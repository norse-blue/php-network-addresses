<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\Validation\AttributeValidators;

use Attribute;
use NorseBlue\NetworkAddresses\Validation\AttributeValidationResult;
use NorseBlue\NetworkAddresses\Validation\AttributeValidator;
use UnexpectedValueException;

#[Attribute(Attribute::TARGET_PROPERTY)]
class IntegerBetween implements AttributeValidator
{
    public function __construct(public readonly int $min, public readonly int $max)
    {
        if ($this->min >= $this->max) {
            throw new UnexpectedValueException("Invalid integer range [$min, $max] given.");
        }
    }

    public function validate(mixed $value): AttributeValidationResult
    {
        if (! is_int($value)) {
            return AttributeValidationResult::invalid("Value `$value` has to be an integer.");
        }

        if ($value < $this->min) {
            return AttributeValidationResult::invalid("Value `$value` has to be greater than or equal to $this->min.");
        }

        if ($value > $this->max) {
            return AttributeValidationResult::invalid("Value `$value` has to be less than or equal to $this->max.");
        }

        return AttributeValidationResult::valid();
    }
}
