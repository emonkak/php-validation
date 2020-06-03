<?php

declare(strict_types=1);

namespace Emonkak\Validation\Constraint;

class Filter implements ConstraintInterface
{
    /**
     * @var string
     */
    private $filter;

    /**
     * @var int
     */
    private $filterId;

    /**
     * @var mixed
     */
    private $options;

    /**
     * @param ?mixed $options
     */
    public function __construct(string $filter, $options = null)
    {
        $filterId = filter_id($filter);
        if ($filterId === false) {
            throw new \InvalidArgumentException("Invalid filter name: `$filter`");
        }

        $this->filter = $filter;
        $this->filterId = $filterId;
        $this->options = $options;
    }

    public function getDeclaration(): string
    {
        return "The value must satisfy the validate filter: {$this->filter}.";
    }

    /**
     * {@inheritdoc}
     */
    public function isSatisfiedBy($value): bool
    {
        $result = $this->options !== null
            ? filter_var($value, $this->filterId, $this->options)
            : filter_var($value, $this->filterId);

        $flags = $this->getFlags();

        if ($flags & FILTER_NULL_ON_FAILURE) {
            return $result !== null;
        } else {
            return $result !== false;
        }
    }

    private function getFlags(): int
    {
        if (is_int($this->options)) {
            return $this->options;
        }

        if (is_array($this->options) && isset($this->options['flags'])) {
            return $this->options['flags'];
        }

        return 0;
    }
}
