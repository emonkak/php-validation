<?php

namespace Emonkak\Validation\Type;

use Emonkak\Validation\Collector\CollectorInterface;

interface TypeInterface
{
    /**
     * @return string
     */
    public function getDeclaration();

    /**
     * @param mixed                   $value
     * @param string                  $key
     * @param CollectorInterface $collector
     * @return bool
     */
    public function validate($value, $key, CollectorInterface $collector);
}
