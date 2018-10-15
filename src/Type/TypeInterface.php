<?php

namespace Emonkak\Validation\Type;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Constraint\ConstraintInterface;

interface TypeInterface
{
    /**
     * @return string
     */
    public function getDeclaration();

    /**
     * @param mixed              $value
     * @param string             $key
     * @param CollectorInterface $collector
     * @return bool
     */
    public function validate($key, $value, CollectorInterface $collector);

    /**
     * @return TypeInterface
     */
    public function allowEmpty();

    /**
     * @return TypeInterface
     */
    public function isOptional();

    /**
     * @param ConstraintInterface[] ...$constraints
     * @return ConstrainedType
     */
    public function withConstraints(ConstraintInterface ...$constraints);

    /**
     * @return TypeInterface
     */
    public function union(TypeInterface ...$types);
}
