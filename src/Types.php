<?php

declare(strict_types=1);

namespace Emonkak\Validation;

use Emonkak\Validation\Constraint\Between;
use Emonkak\Validation\Constraint\DateTime;
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

    public static function any(): TypeInterface
    {
        return new Any();
    }

    public static function array(): TypeInterface
    {
        return new Primitive('array');
    }

    public static function date(): TypeInterface
    {
        return (new Primitive('string'))
           ->withConstraints(new Matches('/^' . self::DATE_PATTERN . '$/'));
    }

    public static function dateTime(): TypeInterface
    {
        return (new Primitive('string'))
           ->withConstraints(new DateTime());
    }

    public static function time(): TypeInterface
    {
        return (new Primitive('string'))
           ->withConstraints(new Matches('/^' . self::TIME_PATTERN . '$/'));
    }

    public static function string(int $minLength = null, int $maxLength = null): TypeInterface
    {
        $type = new Primitive('string');

        if ($minLength !== 0 || $maxLength !== PHP_INT_MAX) {
            $minLength = $minLength ?? 0;
            $maxLength = $maxLength ?? INF;
            $type = $type->withConstraints(new Length($minLength, $maxLength));
        }

        return $type;
    }

    public static function int(int $min = null, int $max = null): TypeInterface
    {
        $type = new Primitive('integer');

        if ($min !== null || $max !== null) {
            $min = $min ?? -INF;
            $max = $max ?? INF;
            $type = $type->withConstraints(new Between($min, $max));
        }

        return $type;
    }

    public static function float(float $min = -INF, float $max = INF): TypeInterface
    {
        $type = new Primitive('double');

        if ($min !== -INF || $max !== INF) {
            $type = $type->withConstraints(new Between($min, $max));
        }

        return $type;
    }

    public static function bool(): TypeInterface
    {
        return new Primitive('boolean');
    }

    public static function digit(): TypeInterface
    {
        return (new Any())
            ->withConstraints(new Filter('int'));
    }

    public static function decimal(): TypeInterface
    {
        return (new Any())
            ->withConstraints(new Filter('float'));
    }

    public static function accepted(): TypeInterface
    {
        return (new Any())
            ->withConstraints(new Filter('boolean', FILTER_NULL_ON_FAILURE));
    }

    public static function arrayOf(TypeInterface $type): TypeInterface
    {
        return new ArrayOf($type);
    }

    /**
     * @param class-string $class
     */
    public static function classOf(string $class): TypeInterface
    {
        return new ClassOf($class);
    }

    public static function oneOf(array $expectedValues, bool $strict = false): TypeInterface
    {
        return new OneOf($expectedValues, $strict);
    }

    /**
     * @param TypeInterface[] $expectedTypes
     */
    public static function oneOfType(array $expectedTypes): TypeInterface
    {
        return new OneOfType($expectedTypes);
    }

    /**
     * @param array<string,TypeInterface> $types
     */
    public static function shape(string $declaration, array $types): TypeInterface
    {
        return new Shape($declaration, $types);
    }
}
