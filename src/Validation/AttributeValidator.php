<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\Validation;

interface AttributeValidator
{
    public function validate(mixed $value): AttributeValidationResult;
}
