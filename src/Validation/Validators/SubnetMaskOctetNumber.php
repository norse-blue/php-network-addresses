<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\Validation\Validators;

use Attribute;
use NorseBlue\NetworkAddresses\Validation\ValidationResult;
use NorseBlue\NetworkAddresses\Validator;

#[Attribute(Attribute::TARGET_PROPERTY)]
class SubnetMaskOctetNumber implements Validator
{
    public function __construct()
    {
    }

    public function validate(mixed $value): ValidationResult
    {
        if ($value === 0) {
            return ValidationResult::valid();
        }

        $bit = $mask = 128;
        do {
            if ($value === $mask) {
                return ValidationResult::valid();
            }

            $mask += ($bit >>= 1);
        } while ($bit > 0);

        return ValidationResult::invalid("Value `$value` is not a valid mask octet number.");
    }
}
