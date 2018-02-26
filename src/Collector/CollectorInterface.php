<?php

namespace Emonkak\Validation\Collector;

use Emonkak\Validation\Type\TypeInterface;

interface CollectorInterface
{
    /**
     * @param mixed         $value
     * @param string        $key
     * @param TypeInterface $type
     */
    public function collect($value, $key, TypeInterface $type);
}
