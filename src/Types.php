<?php

namespace Emonkak\Validation;

use Emonkak\Validation\Constraint\Between;
use Emonkak\Validation\Constraint\Filter;
use Emonkak\Validation\Constraint\Length;
use Emonkak\Validation\Constraint\Matches;
use Emonkak\Validation\Type\Any;
use Emonkak\Validation\Type\ArrayOf;
use Emonkak\Validation\Type\ClassOf;
use Emonkak\Validation\Type\OneOf;
use Emonkak\Validation\Type\OneOfType;
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
        return (new Primitive('string'))
           ->withConstraints(new Matches('/^' . self::DATE_PATTERN . '$/'));
    }

    /**
     * @return TypeInterface
     */
    public static function dateTime()
    {
        return (new Primitive('string'))
           ->withConstraints(new Matches('/^' . self::DATE_PATTERN . ' ' . self::TIME_PATTERN . '$/'));
    }

    /**
     * @return TypeInterface
     */
    public static function time()
    {
        return (new Primitive('string'))
           ->withConstraints(new Matches('/^' . self::TIME_PATTERN . '$/'));
    }

    /**
     * @param int $minLength
     * @param int $maxLength
     * @return TypeInterface
     */
    public static function string($minLength = 0, $maxLength = INF)
    {
        $type = new Primitive('string');

        if ($minLength !== 0 || $maxLength !== INF) {
            $type = $type->withConstraints(new Length($minLength, $maxLength));
        }

        return $type;
    }

    /**
     * @param int $min
     * @param int $max
     * @return TypeInterface
     */
    public static function int($min = -INF, $max = INF)
    {
        $type = new Primitive('integer');

        if ($min !== -INF || $max !== INF) {
            $type = $type->withConstraints(new Between($min, $max));
        }

        return $type;
    }

    /**
     * @param int $min
     * @param int $max
     * @return TypeInterface
     */
    public static function float($min = -INF, $max = INF)
    {
        $type = new Primitive('double');

        if ($min !== -INF || $max !== INF) {
            $type = $type->withConstraints(new Between($min, $max));
        }

        return $type;
    }

    /**
     * @return TypeInterface
     */
    public static function bool()
    {
        return new Primitive('boolean');
    }

    /**
     * @return TypeInterface
     */
    public static function digit()
    {
        return (new Any())
            ->withConstraints(new Filter('int'));
    }

    /**
     * @return TypeInterface
     */
    public static function decimal()
    {
        return (new Any())
            ->withConstraints(new Filter('float'));
    }

    /**
     * @return TypeInterface
     */
    public static function accepted()
    {
        return (new Any())
            ->withConstraints(new Filter('boolean', FILTER_NULL_ON_FAILURE));
    }

    /**
     * @return TypeInterface
     */
    public static function arrayOf(TypeInterface $type)
    {
        return new ArrayOf($type);
    }

    /**
     * @param string $class
     * @return TypeInterface
     */
    public static function classOf($class)
    {
        return new ClassOf($class);
    }

    /**
     * @param mixed[] $expectedValues
     * @param bool    $strict
     * @return TypeInterface
     */
    public static function oneOf(array $expectedValues, $strict = false)
    {
        return new OneOf($expectedValues, $strict);
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
