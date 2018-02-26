<?php

namespace Emonkak\Validation;

interface ErrorBagInterface extends \Countable
{
    /**
     * @return array<string, Error>
     */
    public function getErrors();

    /**
     * @return Error[]
     */
    public function toArray();
}
