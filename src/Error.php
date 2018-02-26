<?php

namespace Emonkak\Validation;

class Error
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $expectedType;

    /**
     * @var string
     */
    private $actualType;

    /**
     * @param string $key
     * @param string $expectedType
     * @param string $actualType
     */
    public function __construct($key, $expectedType, $actualType)
    {
        $this->key = $key;
        $this->expectedType = $expectedType;
        $this->actualType = $actualType;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            'The property `%s` must be `%s`, got `%s`.',
            $this->key,
            $this->expectedType,
            $this->actualType
        );
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getExceptedType()
    {
        return $this->expectedType;
    }

    /**
     * @return string
     */
    public function getActualType()
    {
        return $this->actualType;
    }
}
