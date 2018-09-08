<?php

namespace Emonkak\Validation\Collector;

use Emonkak\Validation\Type\TypeInterface;
use Emonkak\Validation\Constraint\ConstraintInterface;

class NullCollector implements CollectorInterface
{
    /**
     * {@inheritDoc}
     */
    public function collectTypeError($key, $value, TypeInterface $type)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function collectConstraintError($key, $value, ConstraintInterface $constraint)
    {
    }
}
