<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\Validation;

use NorseBlue\NetworkAddresses\Validation\Exceptions\ValidationException;
use ReflectionClass;
use ReflectionProperty;

class AttributeValidatableClass
{
    private ReflectionClass $reflection;

    private object $validatableObject;

    public function __construct(object $validatableObject)
    {
        $this->validatableObject = $validatableObject;
        $this->reflection = new ReflectionClass($this->validatableObject);
    }

    /**
     * @return array<AttributeValidatableProperty>
     */
    public function getProperties(): array
    {
        $publicProperties = array_filter(
            $this->reflection->getProperties(),
            static fn (ReflectionProperty $property) => ! $property->isStatic()
        );

        return array_map(
            fn (ReflectionProperty $property) => new AttributeValidatableProperty(
                $this->validatableObject,
                $property
            ),
            $publicProperties
        );
    }

    /**
     * @throws ValidationException
     */
    public function validate(): void
    {
        $validationErrors = [];

        foreach ($this->getProperties() as $property) {
            $validators = $property->getValidators();

            foreach ($validators as $validator) {
                $result = $validator->validate($property->getValue());

                if ($result->isValid) {
                    continue;
                }

                $validationErrors[$property->name][] = $result;
            }
        }

        if (count($validationErrors)) {
            throw new ValidationException($this->validatableObject, $validationErrors);
        }
    }
}
