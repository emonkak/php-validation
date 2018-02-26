<?php

namespace Emonkak\Validation\Collector;

use Emonkak\Validation\Error;
use Emonkak\Validation\ErrorBagInterface;
use Emonkak\Validation\Type\TypeInterface;

class ErrorCollector implements CollectorInterface, ErrorBagInterface
{
    /**
     * @var Error[]
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
    public function collect($value, $key, TypeInterface $type)
    {
        $this->errors[] = new Error($key, $type->getDeclaration(), gettype($value));
    }
}
