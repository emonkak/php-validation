<?php

declare(strict_types=1);

namespace Emonkak\Validation\Type;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Constraint\ConstraintInterface;

interface TypeInterface
{
    public function getDeclaration(): string;

    /**
     * @param mixed $value
     */
    public function validate(string $key, $value, CollectorInterface $collector): bool;

    public function allowEmpty(): TypeInterface;

    public function isOptional(): TypeInterface;

    public function withConstraints(ConstraintInterface ...$constraints): Constrained;

    public function union(TypeInterface ...$types): TypeInterface;
}
