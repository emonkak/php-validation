<?php

namespace Emonkak\Validation\Type;

use Emonkak\Validation\Collector\CollectorInterface;

class Any implements TypeInterface
{
    use ConstraintTrait;
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
    public function validate($key, $value, CollectorInterface $collector)
    {
        if ($value === null) {
            $collector->collectTypeError($key, $value, $this);
            return false;
        }
        return true;
    }
}
