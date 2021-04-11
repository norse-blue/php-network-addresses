<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\Reflection;

use JetBrains\PhpStorm\Immutable;
use JetBrains\PhpStorm\Pure;
use NorseBlue\NetworkAddresses\Validator;
use ReflectionAttribute;
use ReflectionProperty;

class AttributeValidatableProperty
{
    #[Immutable]
    public string $name;

    private object $validatableObject;

    private ReflectionProperty $reflectionProperty;

    public function __construct(
        object $validatableObject,
        ReflectionProperty $reflectionProperty
    ) {
        $this->validatableObject = $validatableObject;
        $this->reflectionProperty = $reflectionProperty;
        $this->name = $this->reflectionProperty->name;
    }

    /**
     * @return Validator[]
     */
    public function getValidators(): array
    {
        $attributes = $this->reflectionProperty->getAttributes(
            Validator::class,
            ReflectionAttribute::IS_INSTANCEOF
        );

        /** @var Validator[] */
        return array_map(
            static fn (ReflectionAttribute $attribute) => $attribute->newInstance(),
            $attributes
        );
    }

    #[Pure]
    public function getValue(): mixed
    {
        return $this->reflectionProperty->getValue($this->validatableObject);
    }
}
