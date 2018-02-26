<?php

namespace Emonkak\Validation\Type;

use Emonkak\Validation\Collector\CollectorInterface;

class PatternOf implements TypeInterface
{
    use OptionalTrait;

    /**
     * @var string
     */
    private $declaration;

    /**
     * @var string
     */
    private $pattern;

    /**
     * @param string $declaration
     * @param string $pattern
     */
    public function __construct($declaration, $pattern)
    {
        $this->declaration = $declaration;
        $this->pattern = $pattern;
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
        if (!is_string($value) || !preg_match($this->pattern, $value)) {
            $collector->collect($value, $key, $this);
            return false;
        }
        return true;
    }
}
