<?php

declare(strict_types=1);

namespace Emonkak\Validation\Type;

use Emonkak\Validation\Collector\CollectorInterface;

class ArrayOf implements TypeInterface
{
    use TypeTrait;

    /**
     * @var TypeInterface
     */
    private $type;

    public function __construct(TypeInterface $type)
    {
        $this->type = $type;
    }

    public function getItemType(): TypeInterface
    {
        return $this->type;
    }

    public function getDeclaration(): string
    {
        $declaration = $this->type->getDeclaration();
        return $declaration . '[]';
    }

    /**
     * {@inheritdoc}
     */
    public function validate(string $key, $value, CollectorInterface $collector): bool
    {
        if (!is_array($value)) {
            $collector->collectTypeError($key, $value, $this);
            return false;
        }

        $isValid = true;

        foreach ($value as $index => $element) {
            if (!$this->type->validate($key . '[' . $index . ']', $element, $collector)) {
                $isValid = false;
            }
        }

        return $isValid;
    }
}
