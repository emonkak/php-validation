<?php

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

    /**
     * @param string        $key
     * @param mixed         $value
     * @param TypeInterface $expectedType
     */
    public function __construct($key, $value, TypeInterface $expectedType)
    {
        $this->key = $key;
        $this->value = $value;
        $this->expectedType = $expectedType;
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()
    {
        return sprintf(
            'The property `%s` must be `%s`, got `%s`.',
            $this->key,
            $this->expectedType->getDeclaration(),
            gettype($this->value)
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * {@inheritDoc}
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return TypeInterface
     */
    public function getExpectedType()
    {
        return $this->expectedType;
    }
}
