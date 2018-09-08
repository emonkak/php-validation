<?php

namespace Emonkak\Validation\Type;

use Emonkak\Validation\Collector\CollectorInterface;

class Filter implements TypeInterface
{
    use ConstraintTrait;
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
     * @param mixed  $options
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
    public function validate($key, $value, CollectorInterface $collector)
    {
        $result = $this->doFilter($value);

        if (gettype($result) !== $this->declaration) {
            $collector->collectTypeError($key, $value, $this);
            return false;
        }

        return true;
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    private function doFilter($value)
    {
        return $this->options !== null
            ? filter_var($value, $this->filter, $this->options)
            : filter_var($value, $this->filter);
    }
}
