<?php

namespace Emonkak\Validation;

use Emonkak\Validation\Collector\ErrorCollector;
use Emonkak\Validation\Type\TypeInterface;

class Validator
{
    /**
     * @var array<string, TypeInterface>
     */
    private $types;

    /**
     * @param array<string, TypeInterface> $types
     */
    public function __construct(array $types)
    {
        $this->types = $types;
    }

    /**
     * @param array<string, mixed> $data
     * @return ErrorBagInterface
     */
    public function validate(array $data)
    {
        $collector = new ErrorCollector();

        foreach ($this->types as $key => $type) {
            $value = isset($data[$key]) ? $data[$key] : null;

            $type->validate($key, $value, $collector);
        }

        return $collector;
    }
}
