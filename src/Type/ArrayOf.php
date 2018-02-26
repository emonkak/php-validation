<?php

namespace Emonkak\Validation\Type;

use Emonkak\Validation\Collector\CollectorInterface;

class ArrayOf implements TypeInterface
{
    use OptionalTrait;

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
        return ($isUnionType ? "($declaration)" : $declaration) . '[]';
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

        foreach ($value as $index => $element) {
            if (!$this->type->validate($element, $key . '[' . $index . ']', $collector)) {
                $isValid = false;
            }
        }

        return $isValid;
    }
}
