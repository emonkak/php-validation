<?php

namespace Emonkak\Validation;

interface ErrorInterface
{
    /**
     * @return string
     */
    public function __toString();

    /**
     * @return string
     */
    public function getKey();

    /**
     * @return string
     */
    public function getValue();
}
