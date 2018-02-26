<?php

namespace Emonkak\Validation;

use Emonkak\Validation\Type\Any;
use Emonkak\Validation\Type\ArrayOf;
use Emonkak\Validation\Type\Filter;
use Emonkak\Validation\Type\OneOf;
use Emonkak\Validation\Type\OneOfType;
use Emonkak\Validation\Type\PatternOf;
use Emonkak\Validation\Type\Primitive;
use Emonkak\Validation\Type\Shape;
use Emonkak\Validation\Type\TypeInterface;

final class Types
{
    const DATE_PATTERN = '\d{4}-(?:1[0-2]|0[1-9])-(?:3[0-1]|[1-2][0-9]|0[1-9])';
    const TIME_PATTERN = '(?:2[0-3]|[0-1][0-9]):[0-5][0-9](?::[0-5][0-9])?';

    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }

    /**
     * @return TypeInterface
     */
    public static function any()
    {
        return new Any();
    }

    /**
     * @return TypeInterface
     */
    public static function date()
    {
        return new PatternOf('Date', '/^' . self::DATE_PATTERN . '$/');
    }

    /**
     * @return TypeInterface
     */
    public static function dateTime()
    {
        return new PatternOf('DateTime', '/^' . self::DATE_PATTERN . ' ' . self::TIME_PATTERN . '$/');
    }

    /**
     * @return TypeInterface
     */
    public static function time()
    {
        return new PatternOf('Time', '/^' . self::TIME_PATTERN . '$/');
    }

    /**
     * @return TypeInterface
     */
    public static function string()
    {
        return new Primitive('string');
    }

    /**
     * @return TypeInterface
     */
    public static function int()
    {
        return new Filter('integer', FILTER_VALIDATE_INT);
    }

    /**
     * @return TypeInterface
     */
    public static function intValue()
    {
        return new Primitive('integer');
    }

    /**
     * @return TypeInterface
     */
    public static function float()
    {
        return new Filter('double', FILTER_VALIDATE_FLOAT);
    }

    /**
     * @return TypeInterface
     */
    public static function floatValue()
    {
        return new Primitive('double');
    }

    /**
     * @return TypeInterface
     */
    public static function bool()
    {
        return new Filter('boolean', FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }

    /**
     * @return TypeInterface
     */
    public static function boolValue()
    {
        return new Primitive('boolean');
    }

    /**
     * @return TypeInterface
     */
    public static function arrayOf(TypeInterface $type)
    {
        return new ArrayOf($type);
    }

    /**
     * @param mixed[] $expectedValues
     * @return TypeInterface
     */
    public static function oneOf(array $expectedValues)
    {
        return new OneOf($expectedValues);
    }

    /**
     * @param TypeInterface[] $expectedValues
     * @return TypeInterface
     */
    public static function oneOfType(array $expectedTypes)
    {
        return new OneOfType($expectedTypes);
    }

    /**
     * @param string $declaration
     * @param array<string, TypeInterface> $types
     * @return TypeInterface
     */
    public static function shape($declaration, array $types)
    {
        return new Shape($declaration, $types);
    }
}
