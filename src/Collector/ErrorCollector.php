<?php

declare(strict_types=1);

namespace Emonkak\Validation\Collector;

use Emonkak\Validation\Constraint\ConstraintInterface;
use Emonkak\Validation\ConstraintError;
use Emonkak\Validation\ErrorBagInterface;
use Emonkak\Validation\ErrorInterface;
use Emonkak\Validation\Type\TypeInterface;
use Emonkak\Validation\TypeError;

class ErrorCollector implements CollectorInterface, ErrorBagInterface
{
    /**
     * @var ErrorInterface[]
     */
    private $errors = [];

    /**
     * {@inheritdoc}
     */
    public function getErrors(): array
    {
        $errors = [];

        foreach ($this->errors as $error) {
            $errors[$error->getKey()][] = $error;
        }

        return $errors;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return $this->errors;
    }

    public function count(): int
    {
        return count($this->errors);
    }

    /**
     * {@inheritdoc}
     */
    public function collectTypeError(string $key, $value, TypeInterface $type): void
    {
        $this->errors[] = new TypeError($key, $value, $type);
    }

    /**
     * {@inheritdoc}
     */
    public function collectConstraintError(string $key, $value, ConstraintInterface $constraint): void
    {
        $this->errors[] = new ConstraintError($key, $value, $constraint);
    }
}
