<?php

declare(strict_types=1);

namespace Emonkak\Validation;

use Emonkak\Validation\Type\TypeInterface;

class TypeError implements ErrorInterface
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @var TypeInterface
     */
    private $expectedType;

    public function __construct(string $key, $value, TypeInterface $expectedType)
    {
        $this->key = $key;
        $this->value = $value;
        $this->expectedType = $expectedType;
    }

    public function __toString(): string
    {
        return sprintf(
            'The property `%s` must be `%s`, got `%s`.',
            $this->key,
            $this->expectedType->getDeclaration(),
            gettype($this->value)
        );
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getExpectedType(): TypeInterface
    {
        return $this->expectedType;
    }
}
