<?php

namespace Emonkak\Validation\Type;

use Emonkak\Validation\Collector\CollectorInterface;

class Any implements TypeInterface
{
    use OptionalTrait;

    /**
     * {@inheritDoc}
     */
    public function getDeclaration()
    {
        return 'any';
    }

    /**
     * {@inheritDoc}
     */
    public function validate($value, $key, CollectorInterface $collector)
    {
        if ($value === null) {
            $collector->collect($value, $key, $this);
            return false;
        }
        return true;
    }
}
