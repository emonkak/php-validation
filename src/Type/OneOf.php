<?php

namespace Emonkak\Validation\Type;

use Emonkak\Validation\Collector\CollectorInterface;

class OneOf implements TypeInterface
{
    use OptionalTrait;

    /**
     * @var mixed[]
     */
    private $expectedValues;

    /**
     * @param mixed[] $expectedValues
     * @param string  $message
     */
    public function __construct(array $expectedValues)
    {
        $this->expectedValues = $expectedValues;
    }

    /**
     * {@inheritDoc}
     */
    public function getDeclaration()
    {
        return implode('|', array_map('json_encode', $this->expectedValues));
    }

    /**
     * {@inheritDoc}
     */
    public function validate($value, $key, CollectorInterface $collector)
    {
        if (!in_array($value, $this->expectedValues)) {
            $collector->collect($value, $key, $this);
            return false;
        }
        return true;
    }
}
