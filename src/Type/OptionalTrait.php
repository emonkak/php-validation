<?php

namespace Emonkak\Validation\Type;

trait OptionalTrait
{
    /**
     * @return TypeInterface
     */
    public function isOptional()
    {
        return new Optional($this);
    }
}
