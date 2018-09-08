<?php

namespace Emonkak\Validation\Type;

trait OptionalTrait
{
    /**
     * @return Optional
     */
    public function isOptional()
    {
        return new Optional($this);
    }
}
