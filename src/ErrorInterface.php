<?php

declare(strict_types=1);

namespace Emonkak\Validation;

interface ErrorInterface
{
    public function __toString(): string;

    /**
     * @return string
     */
    public function getKey(): string;

    public function getValue();
}
