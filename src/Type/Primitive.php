<?php

declare(strict_types=1);

namespace Emonkak\Validation\Type;

use Emonkak\Validation\Collector\CollectorInterface;

class Primitive implements TypeInterface
{
    use TypeTrait;

    /**
     * @var string
     */
    private $declaration;

    public function __construct(string $declaration)
    {
        $this->declaration = $declaration;
    }

    public function getDeclaration(): string
    {
        return $this->declaration;
    }

    /**
     * {@inheritdoc}
     */
    public function validate(string $key, $value, CollectorInterface $collector): bool
    {
        if (gettype($value) !== $this->declaration) {
            $collector->collectTypeError($key, $value, $this);
            return false;
        }
        return true;
    }
}
