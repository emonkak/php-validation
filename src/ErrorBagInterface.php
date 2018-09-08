<?php

namespace Emonkak\Validation;

interface ErrorBagInterface extends \Countable
{
    /**
     * @return array<string, ErrorInterface>
     */
    public function getErrors();

    /**
     * @return ErrorInterface[]
     */
    public function toArray();
}
