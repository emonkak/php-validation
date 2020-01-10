<?php

declare(strict_types=1);

namespace Emonkak\Validation\Type;

use Emonkak\Validation\Collector\CollectorInterface;

class Any implements TypeInterface
{
    use TypeTrait;

    public function getDeclaration(): string
    {
        return 'any';
    }

    public function validate(string $key, $value, CollectorInterface $collector): bool
    {
        if ($value === null) {
            $collector->collectTypeError($key, $value, $this);
            return false;
        }
        return true;
    }
}
