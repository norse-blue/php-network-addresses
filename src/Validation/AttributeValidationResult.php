<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\Validation;

class AttributeValidationResult
{
    public function __construct(
        public readonly bool $isValid,
        public readonly ?string $message = null
    ) {
    }

    public static function invalid(string $message): self
    {
        return new self(false, $message);
    }

    public static function valid(): self
    {
        return new self(true);
    }
}
