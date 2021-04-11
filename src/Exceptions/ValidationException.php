<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\Exceptions;

use JetBrains\PhpStorm\Pure;
use NorseBlue\NetworkAddresses\Validation\ValidationResult;
use RuntimeException;

class ValidationException extends RuntimeException
{
    /**
     * @param array<string, ValidationResult[]> $validationErrors
     */
    #[Pure]
    public function __construct(
        object $validatableObject,
        array $validationErrors
    ) {
        $className = $validatableObject::class;
        $messages = [];

        foreach ($validationErrors as $fieldName => $errorsForField) {
            foreach ($errorsForField as $errorForField) {
                $messages[] = "\t - `$className->$fieldName`: $errorForField->message";
            }
        }

        parent::__construct("Validation errors:" . PHP_EOL . implode(PHP_EOL, $messages));
    }
}
