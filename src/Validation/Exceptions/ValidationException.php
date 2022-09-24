<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\Validation\Exceptions;

use NorseBlue\NetworkAddresses\Validation\AttributeValidationResult;
use RuntimeException;

class ValidationException extends RuntimeException
{
    /**
     * @param  array<string, array<AttributeValidationResult>>  $validationErrors
     */
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

        parent::__construct('Validation errors:'.PHP_EOL.implode(PHP_EOL, $messages));
    }
}
