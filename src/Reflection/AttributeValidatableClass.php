<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\Reflection;

use NorseBlue\NetworkAddresses\Exceptions\ValidationException;
use ReflectionClass;
use ReflectionProperty;

class AttributeValidatableClass
{
    /** @var ReflectionClass<object>  */
    private ReflectionClass $reflectionClass;
    private object $validatableObject;

    public function __construct(object $validatableObject)
    {
        $this->validatableObject = $validatableObject;
        $this->reflectionClass = new ReflectionClass($this->validatableObject);
    }

    /**
     * @return AttributeValidatableProperty[]
     */
    public function getProperties(): array
    {
        $publicProperties = array_filter(
            $this->reflectionClass->getProperties(),
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
