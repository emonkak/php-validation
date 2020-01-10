<?php

declare(strict_types=1);

namespace Emonkak\Validation\Type;

use Emonkak\Validation\Collector\CollectorInterface;

class Optional implements TypeInterface
{
    use TypeTrait;

    /**
     * @var TypeInterface
     */
    private $type;

    /**
     * @param TypeInterface $type
     */
    public function __construct(TypeInterface $type)
    {
        $this->type = $type;
    }

    public function getType(): TypeInterface
    {
        return $this->type;
    }

    public function getDeclaration(): string
    {
        $declaration = $this->type->getDeclaration();
        return '?' . $declaration;
    }

    public function validate(string $key, $value, CollectorInterface $collector): bool
    {
        if ($value !== null) {
            if (!$this->type->validate($key, $value, $collector)) {
                return false;
            }
        }
        return true;
    }
}
