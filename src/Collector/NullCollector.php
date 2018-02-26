<?php

namespace Emonkak\Validation\Collector;

use Emonkak\Validation\Type\TypeInterface;

class NullCollector implements CollectorInterface
{
    /**
     * {@inheritDoc}
     */
    public function collect($value, $key, TypeInterface $type)
    {
    }
}
