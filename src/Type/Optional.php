<?php

namespace Emonkak\Validation\Type;

use Emonkak\Validation\Collector\CollectorInterface;

class Optional implements TypeInterface
{
    use ConstraintTrait;

    /**
     * @var TypeInterface
     */
    private $type;

    /**
     * @param TypeInterface $type
     */
    public function __construct(TypeInterface $type)
    {
        $this->type = $type;
    }

    /**
     * @return TypeInterface
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritDoc}
     */
    public function getDeclaration()
    {
        $declaration = $this->type->getDeclaration();
        return '?' . $declaration;
    }

    /**
     * {@inheritDoc}
     */
    public function validate($key, $value, CollectorInterface $collector)
    {
        if ($value !== null) {
            if (!$this->type->validate($key, $value, $collector)) {
                return false;
            }
        }
        return true;
    }
}
