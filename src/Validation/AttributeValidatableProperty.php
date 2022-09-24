<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\Validation;

use ReflectionAttribute;
use ReflectionProperty;

class AttributeValidatableProperty
{
    public string $name;

    private ReflectionProperty $reflectedProperty;

    private object $validatableObject;

    public function __construct(
        object $validatableObject,
        ReflectionProperty $reflectionProperty
    ) {
        $this->validatableObject = $validatableObject;
        $this->reflectedProperty = $reflectionProperty;
        $this->name = $this->reflectedProperty->name;
    }

    /**
     * @return array<AttributeValidator>
     */
    public function getValidators(): array
    {
        $attributes = $this->reflectedProperty->getAttributes(
            AttributeValidator::class,
            ReflectionAttribute::IS_INSTANCEOF
        );

        return array_map(
            static fn (ReflectionAttribute $attribute) => $attribute->newInstance(),
            $attributes
        );
    }

    public function getValue(): mixed
    {
        return $this->reflectedProperty->getValue($this->validatableObject);
    }
}
