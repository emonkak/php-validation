<?php

declare(strict_types=1);

namespace Emonkak\Validation;

interface ErrorInterface
{
    public function __toString(): string;

    public function getKey(): string;

    /**
     * @return mixed
     */
    public function getValue();
}
