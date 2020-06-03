<?php

declare(strict_types=1);

namespace Emonkak\Validation;

interface ErrorBagInterface extends \Countable
{
    /**
     * @return array<string,ErrorInterface[]>
     */
    public function getErrors(): array;

    /**
     * @return ErrorInterface[]
     */
    public function toArray(): array;
}
