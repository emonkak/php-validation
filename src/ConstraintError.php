<?php

namespace Emonkak\Validation;

class ConstraintError
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
     * @var ConstraintInterface
     */
    private $constraint;

    /**
     * @param string              $key
     * @param mixed               $value
     * @param ConstraintInterface $constraint
     */
    public function __construct($key, $value, $constraint)
    {
        $this->key = $key;
        $this->value = $value;
        $this->constraint = $constraint;
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()
    {
        return sprintf(
            'The property `%s` must satisfy the constraint `%s`, got `%s`.',
            $this->key,
            $this->constraint->getDeclaration(),
            var_export($this->value, true)
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
     * @return ConstraintInterface
     */
    public function getConstraint()
    {
        return $this->constraint;
    }
}
