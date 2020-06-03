<?php

declare(strict_types=1);

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
     * @var bool
     */
    private $strict;

    /**
     * @param mixed[] $expectedValues
     */
    public function __construct(array $expectedValues, bool $strict)
    {
        $this->expectedValues = $expectedValues;
        $this->strict = $strict;
    }

    /**
     * @return mixed[]
     */
    public function getExpectedValues(): array
    {
        return $this->expectedValues;
    }

    public function getDeclaration(): string
    {
        return '(' . implode('|', array_map('json_encode', $this->expectedValues)) . ')';
    }

    /**
     * {@inheritdoc}
     */
    public function validate(string $key, $value, CollectorInterface $collector): bool
    {
        if (!in_array($value, $this->expectedValues, $this->strict)) {
            $collector->collectTypeError($key, $value, $this);
            return false;
        }
        return true;
    }
}
