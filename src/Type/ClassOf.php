<?php

namespace Emonkak\Validation\Type;

use Emonkak\Validation\Collector\CollectorInterface;

class ClassOf implements TypeInterface
{
    use TypeTrait;

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
    public function validate($key, $value, CollectorInterface $collector)
    {
        if (!($value instanceof $this->class)) {
            $collector->collectTypeError($key, $value, $this);
            return false;
        }
        return true;
    }
}
