<?php

namespace Emonkak\Validation\Collector;

use Emonkak\Validation\ConstraintError;
use Emonkak\Validation\Constraint\ConstraintInterface;
use Emonkak\Validation\ErrorBagInterface;
use Emonkak\Validation\TypeError;
use Emonkak\Validation\Type\TypeInterface;

class ErrorCollector implements CollectorInterface, ErrorBagInterface
{
    /**
     * @var ErrorInterface[]
     */
    private $errors = [];

    /**
     * {@inheritDoc}
     */
    public function getErrors()
    {
        $errors = [];

        foreach ($this->errors as $error) {
            $errors[$error->getKey()][] = $error;
        }

        return $errors;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
        return $this->errors;
    }

    /**
     * {@inheritDoc}
     */
    public function count()
    {
        return count($this->errors);
    }

    /**
     * {@inheritDoc}
     */
    public function collectTypeError($key, $value, TypeInterface $type)
    {
        $this->errors[] = new TypeError($key, $value, $type);
    }

    /**
     * {@inheritDoc}
     */
    public function collectConstraintError($key, $value, ConstraintInterface $constraint)
    {
        $this->errors[] = new ConstraintError($key, $value, $constraint);
    }
}
