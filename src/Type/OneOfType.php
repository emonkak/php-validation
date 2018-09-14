<?php

namespace Emonkak\Validation\Type;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Collector\NullCollector;

class OneOfType implements TypeInterface
{
    use TypeTrait;

    /**
     * @param TypeInterface[] $types
     */
    public function __construct(array $types)
    {
        $this->types = $types;
    }

    /**
     * @return TypeInterface[]
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * {@inheritDoc}
     */
    public function getDeclaration()
    {
        $declarations = [];

        foreach ($this->types as $type) {
            $declarations[] = $type->getDeclaration();
        }

        return '(' . implode('|', $declarations) . ')';
    }

    /**
     * {@inheritDoc}
     */
    public function validate($key, $value, CollectorInterface $collector)
    {
        $isValid = false;
        $nullCollector = new NullCollector();

        foreach ($this->types as $type) {
            if ($type->validate($key, $value, $nullCollector)) {
                $isValid = true;
                break;
            }
        }

        if (!$isValid) {
            $collector->collectTypeError($key, $value, $this);
        }

        return $isValid;
    }

    /**
     * @return TypeInterface
     */
    public function union(TypeInterface ...$types)
    {
        return new OneOfType(array_merge($this->types, $types));
    }
}
