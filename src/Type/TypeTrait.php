<?php

declare(strict_types=1);

namespace Emonkak\Validation\Type;

use Emonkak\Validation\Constraint\ConstraintInterface;

trait TypeTrait
{
    public function allowEmpty(): TypeInterface
    {
        assert($this instanceof TypeInterface);
        return new OneOfType([$this, new OneOf(['', null], true)]);
    }

    public function isOptional(): TypeInterface
    {
        assert($this instanceof TypeInterface);
        return new Optional($this);
    }

    public function withConstraints(ConstraintInterface ...$constraints): Constrained
    {
        assert($this instanceof TypeInterface);
        return new Constrained($this, $constraints);
    }

    public function union(TypeInterface ...$types): TypeInterface
    {
        return new OneOfType(array_merge([$this], $types));
    }
}
