<?php

declare(strict_types=1);

namespace Emonkak\Validation\Type;

use Emonkak\Validation\Collector\CollectorInterface;

class ClassOf implements TypeInterface
{
    use TypeTrait;

    /**
     * @var class-string
     */
    private $class;

    /**
     * @param class-string $class
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    public function getDeclaration(): string
    {
        return $this->class;
    }

    /**
     * {@inheritdoc}
     */
    public function validate(string $key, $value, CollectorInterface $collector): bool
    {
        if (!($value instanceof $this->class)) {
            $collector->collectTypeError($key, $value, $this);
            return false;
        }
        return true;
    }
}
