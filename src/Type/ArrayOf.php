<?php

namespace Emonkak\Validation\Type;

use Emonkak\Validation\Collector\CollectorInterface;

class ArrayOf implements TypeInterface
{
    use TypeTrait;

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
    public function getItemType()
    {
        return $this->type;
    }

    /**
     * {@inheritDoc}
     */
    public function getDeclaration()
    {
        $declaration = $this->type->getDeclaration();
        return $declaration . '[]';
    }

    /**
     * {@inheritDoc}
     */
    public function validate($key, $value, CollectorInterface $collector)
    {
        if (!is_array($value)) {
            $collector->collectTypeError($key, $value, $this);
            return false;
        }

        $isValid = true;

        foreach ($value as $index => $element) {
            if (!$this->type->validate($key . '[' . $index . ']', $element, $collector)) {
                $isValid = false;
            }
        }

        return $isValid;
    }
}
