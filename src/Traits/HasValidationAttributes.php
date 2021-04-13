<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\Traits;

use NorseBlue\NetworkAddresses\Reflection\AttributeValidatableClass;

trait HasValidationAttributes
{
    protected function validateAttributes(): void
    {
        $class = new AttributeValidatableClass($this);
        $class->validate();
    }
}
