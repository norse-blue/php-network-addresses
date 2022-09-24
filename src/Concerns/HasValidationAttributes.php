<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\Concerns;

use NorseBlue\NetworkAddresses\Validation\AttributeValidatableClass;

trait HasValidationAttributes
{
    protected function validateAttributes(): void
    {
        $class = new AttributeValidatableClass($this);
        $class->validate();
    }
}
