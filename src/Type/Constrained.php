<?php

declare(strict_types=1);

namespace Emonkak\Validation\Type;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Constraint\ConstraintInterface;

class Constrained implements TypeInterface
{
    use TypeTrait;

    /**
     * @var TypeInterface
     */
    private $type;

    /**
     * @var ConstraintInterface[]
     */
    private $constraints;

    /**
     * @param ConstraintInterface[] $constraints
     */
    public function __construct(TypeInterface $type, array $constraints)
    {
        $this->type = $type;
        $this->constraints = $constraints;
    }

    public function getType(): TypeInterface
    {
        return $this->type;
    }

    /**
     * @return ConstraintInterface[]
     */
    public function getConstraints()
    {
        return $this->constraints;
    }

    public function getDeclaration(): string
    {
        return $this->type->getDeclaration();
    }

    /**
     * {@inheritdoc}
     */
    public function validate(string $key, $value, CollectorInterface $collector): bool
    {
        if (!$this->type->validate($key, $value, $collector)) {
            return false;
        }

        foreach ($this->constraints as $constraint) {
            if (!$constraint->isSatisfiedBy($value)) {
                $collector->collectConstraintError($key, $value, $constraint);
                return false;
            }
        }

        return true;
    }

    public function withConstraints(ConstraintInterface ...$constraints): Constrained
    {
        return new Constrained(
            $this->type,
            array_merge($this->constraints, $constraints)
        );
    }
}
