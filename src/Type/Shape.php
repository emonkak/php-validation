<?php

namespace Emonkak\Validation\Type;

use Emonkak\Validation\Collector\CollectorInterface;

class Shape implements TypeInterface
{
    use OptionalTrait;

    /**
     * @var string
     */
    private $declaration;

    /**
     * @var array<string, TypeInterface>
     */
    private $types;

    /**
     * @param string                       $declaration
     * @param array<string, TypeInterface> $types
     */
    public function __construct($declaration, array $types)
    {
        $this->declaration = $declaration;
        $this->types = $types;
    }

    /**
     * {@inheritDoc}
     */
    public function getDeclaration()
    {
        return $this->declaration;
    }

    /**
     * {@inheritDoc}
     */
    public function validate($value, $key, CollectorInterface $collector)
    {
        if (!is_array($value)) {
            $collector->collect($value, $key, $this);
            return false;
        }

        $isValid = true;

        foreach ($this->types as $subKey => $type) {
            $subValue = isset($value[$subKey]) ? $value[$subKey] : null;

            if (!$type->validate($subValue, $key . '.' . $subKey, $collector)) {
                $isValid = false;
            }
        }

        return $isValid;
    }
}
