<?php

namespace Emonkak\Validation\Type;

use Emonkak\Validation\Collector\CollectorInterface;

class Filter implements TypeInterface
{
    use OptionalTrait;

    /**
     * @var string
     */
    private $declaration;

    /**
     * @var string
     */
    private $filter;

    /**
     * @var mixed
     */
    private $options;

    /**
     * @param string $declaration
     * @param string $filter
     * @param mixed $options
     */
    public function __construct($declaration, $filter, $options = null)
    {
        $this->declaration = $declaration;
        $this->filter = $filter;
        $this->options = $options;
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
        $result = $this->options !== null
            ? filter_var($value, $this->filter, $this->options)
            : filter_var($value, $this->filter);

        if (gettype($result) !== $this->declaration) {
            $collector->collect($value, $key, $this);
            return false;
        }

        return true;
    }
}
