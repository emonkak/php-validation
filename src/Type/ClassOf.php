<?php

namespace Emonkak\Validation\Type;

use Emonkak\Validation\Collector\CollectorInterface;

class ClassOf implements TypeInterface
{
    use OptionalTrait;

    /**
     * @var string
     */
    private $class;

    /**
     * @param string $class
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * {@inheritDoc}
     */
    public function getDeclaration()
    {
        return $this->class;
    }

    /**
     * {@inheritDoc}
     */
    public function validate($value, $key, CollectorInterface $collector)
    {
        if (!($value instanceof $this->class)) {
            $collector->collect($value, $key, $this);
            return false;
        }
        return true;
    }
}
