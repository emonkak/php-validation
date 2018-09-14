<?php

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
     * @param TypeInterface         $type
     * @param ConstraintInterface[] $constraints
     */
    public function __construct(TypeInterface $type, array $constraints)
    {
        $this->type = $type;
        $this->constraints = $constraints;
    }

    /**
     * @return TypeInterface
     */
    public function getType()
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

    /**
     * {@inheritDoc}
     */
    public function getDeclaration()
    {
        return $this->type->getDeclaration();
    }

    /**
     * {@inheritDoc}
     */
    public function validate($key, $value, CollectorInterface $collector)
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

    /**
     * @param ConstraintInterface[] $constraints
     * @return $this
     */
    public function withConstraints(ConstraintInterface ...$constraints)
    {
        return new Constrained(
            $this->type,
            array_merge($this->constraints, $constraints)
        );
    }
}
