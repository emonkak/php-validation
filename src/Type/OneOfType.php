<?php

namespace Emonkak\Validation\Type;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Collector\NullCollector;

class OneOfType implements TypeInterface
{
    use OptionalTrait;

    /**
     * @param TypeInterface[] $types
     */
    public function __construct(array $types)
    {
        $this->types = $types;
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

        return implode('|', $declarations);
    }

    /**
     * {@inheritDoc}
     */
    public function validate($value, $key, CollectorInterface $collector)
    {
        $isValid = false;
        $nullCollector = new NullCollector();

        foreach ($this->types as $type) {
            if ($type->validate($value, $key, $nullCollector)) {
                $isValid = true;
                break;
            }
        }

        if (!$isValid) {
            $collector->collect($value, $key, $this);
        }

        return $isValid;
    }
}
