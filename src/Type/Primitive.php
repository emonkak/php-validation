<?php

namespace Emonkak\Validation\Type;

use Emonkak\Validation\Collector\CollectorInterface;

class Primitive implements TypeInterface
{
    use OptionalTrait;

    /**
     * @var string
     */
    private $declaration;

    /**
     * @param string $type
     */
    public function __construct($declaration)
    {
        $this->declaration = $declaration;
    }

    /**
     * {@inheritDoc}
     */
    public function getDeclaration()
    {
        return $this->declaration;
    }

    /**
     * {@inheritDoc}
     */
    public function validate($value, $key, CollectorInterface $collector)
    {
        if (gettype($value) !== $this->declaration) {
            $collector->collect($value, $key, $this);
            return false;
        }
        return true;
    }
}
