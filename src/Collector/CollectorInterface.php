<?php

namespace Emonkak\Validation\Collector;

use Emonkak\Validation\Type\TypeInterface;
use Emonkak\Validation\Constraint\ConstraintInterface;

interface CollectorInterface
{
    /**
     * @param string        $key
     * @param mixed         $value
     * @param TypeInterface $type
     */
    public function collectTypeError($key, $value, TypeInterface $type);

    /**
     * @param string              $key
     * @param mixed               $value
     * @param ConstraintInterface $type
     */
    public function collectConstraintError($key, $value, ConstraintInterface $type);
}
