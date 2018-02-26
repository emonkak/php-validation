<?php

namespace Emonkak\Validation\Type;

use Emonkak\Validation\Collector\CollectorInterface;

class Optional implements TypeInterface
{
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
     * {@inheritDoc}
     */
    public function getDeclaration()
    {
        $declaration = $this->type->getDeclaration();
        $isUnionType = strpos($declaration, '|') !== false;
        return '?' . ($isUnionType ? "($declaration)" : $declaration);
    }

    /**
     * {@inheritDoc}
     */
    public function validate($value, $key, CollectorInterface $collector)
    {
        if ($value !== null) {
            if (!$this->type->validate($value, $key, $collector)) {
                return false;
            }
        }
        return true;
    }
}
