<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses;

use NorseBlue\NetworkAddresses\Validation\ValidationResult;

interface Validator
{
    public function validate(mixed $value): ValidationResult;
}
