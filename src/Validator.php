<?php

declare(strict_types=1);

namespace Emonkak\Validation;

use Emonkak\Validation\Collector\ErrorCollector;
use Emonkak\Validation\Type\TypeInterface;

class Validator
{
    /**
     * @var array<string,TypeInterface>
     */
    private $types;

    /**
     * @param array<string,TypeInterface> $types
     */
    public function __construct(array $types)
    {
        $this->types = $types;
    }

    /**
     * @return array<string,TypeInterface>
     */
    public function getTypes(): array
    {
        return $this->types;
    }

    /**
     * @param array<string,mixed> $data
     */
    public function validate(array $data): ErrorBagInterface
    {
        $collector = new ErrorCollector();

        foreach ($this->types as $key => $type) {
            $value = isset($data[$key]) ? $data[$key] : null;

            $type->validate($key, $value, $collector);
        }

        return $collector;
    }
}
