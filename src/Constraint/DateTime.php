<?php

declare(strict_types=1);

namespace Emonkak\Validation\Constraint;

class DateTime implements ConstraintInterface
{
    public function getDeclaration(): string
    {
        return 'The string must be a valid date and time format.';
    }

    public function isSatisfiedBy($value): bool
    {
        if (strtotime($value) === false) {
            return false;
        }
        if (date_create($value) === false) {
            return false;
        }
        $errors = date_get_last_errors();
        if ($errors['warning_count'] > 0) {
            return false;
        }
        return true;
    }
}
