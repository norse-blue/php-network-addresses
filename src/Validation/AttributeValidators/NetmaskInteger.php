<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\Validation\AttributeValidators;

use Attribute;
use NorseBlue\NetworkAddresses\Validation\AttributeValidationResult;
use NorseBlue\NetworkAddresses\Validation\AttributeValidator;

#[Attribute(Attribute::TARGET_PROPERTY)]
class NetmaskInteger implements AttributeValidator
{
    public const VALID_INTEGERS = [0, 128, 192, 224, 240, 248, 252, 254, 255];

    public function __construct()
    {
    }

    public function validate(mixed $value): AttributeValidationResult
    {
        if (! is_int($value)) {
            return AttributeValidationResult::invalid("Value `$value` has to be an integer.");
        }

        if (! in_array($value, self::VALID_INTEGERS, true)) {
            return AttributeValidationResult::invalid("Value `$value` is not a valid mask octet number.");
        }

        return AttributeValidationResult::valid();
    }
}
