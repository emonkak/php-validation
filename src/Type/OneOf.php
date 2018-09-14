<?php

namespace Emonkak\Validation\Type;

use Emonkak\Validation\Collector\CollectorInterface;

class OneOf implements TypeInterface
{
    use TypeTrait;

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
     * @return mixed[]
     */
    public function getExpectedValues()
    {
        return $this->expectedValues;
    }

    /**
     * {@inheritDoc}
     */
    public function getDeclaration()
    {
        return '(' . implode('|', array_map('json_encode', $this->expectedValues)) . ')';
    }

    /**
     * {@inheritDoc}
     */
    public function validate($key, $value, CollectorInterface $collector)
    {
        if (!in_array($value, $this->expectedValues, true)) {
            $collector->collectTypeError($key, $value, $this);
            return false;
        }
        return true;
    }
}
