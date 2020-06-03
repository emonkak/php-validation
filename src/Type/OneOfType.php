<?php

declare(strict_types=1);

namespace Emonkak\Validation\Type;

use Emonkak\Validation\Collector\CollectorInterface;
use Emonkak\Validation\Collector\NullCollector;

class OneOfType implements TypeInterface
{
    use TypeTrait;

    /**
     * @var TypeInterface[]
     */
    private $types;

    /**
     * @param TypeInterface[] $types
     */
    public function __construct(array $types)
    {
        $this->types = $types;
    }

    /**
     * @return TypeInterface[]
     */
    public function getTypes(): array
    {
        return $this->types;
    }

    public function getDeclaration(): string
    {
        $declarations = [];

        foreach ($this->types as $type) {
            $declarations[] = $type->getDeclaration();
        }

        return '(' . implode('|', $declarations) . ')';
    }

    /**
     * {@inheritdoc}
     */
    public function validate(string $key, $value, CollectorInterface $collector): bool
    {
        $isValid = false;
        $nullCollector = new NullCollector();

        foreach ($this->types as $type) {
            if ($type->validate($key, $value, $nullCollector)) {
                $isValid = true;
                break;
            }
        }

        if (!$isValid) {
            $collector->collectTypeError($key, $value, $this);
        }

        return $isValid;
    }

    public function union(TypeInterface ...$types): TypeInterface
    {
        return new OneOfType(array_merge($this->types, $types));
    }
}
