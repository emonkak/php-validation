# Emonkak\Validation

[![Build Status](https://travis-ci.org/emonkak/php-validation.svg?branch=master)](https://travis-ci.org/emonkak/php-validation)
[![Coverage Status](https://coveralls.io/repos/github/emonkak/php-validation/badge.svg?branch=master)](https://coveralls.io/github/emonkak/php-validation?branch=master)

## Example

```php
use Emonkak\Validation\Types;
use Emonkak\Validation\Validator;

$validator = new Validator([
    'foo' => Types::oneOfType([Types::int(), Types::bool()]),
    'bar' => Types::string(),
    'baz' => Types::bool(),
    'qux' => Types::any(),
    'quux' => Types::arrayOf(Types::string()),
    'foobar' => Types::string()->isOptional(),
    'piyo' => Types::oneOf(['foo', 'bar']),
    'puyo' => Types::shape('Puyo', ['foo' => Types::string()]),
    'payo' => Types::dateTime(),
]);

$errors = $validator->validate([
    'foo' => 'foo',
    'bar' => '123',
    'baz' => 'true',
    'qux' => null,
    'quux' => ['1', '2'],
    'puyo' => ['foo' => 123],
    'payo' => '2000-01-01 00:00:00'
]);

foreach ($errors->getErrors() as $key => $errors) {
    echo $key, ': ', implode(' ', $errors), PHP_EOL;
}

// OUTPUT:
// foo: The property `foo` must be `integer|boolean`, got `string`.
// qux: The property `qux` must be `any`, got `NULL`.
// piyo: The property `piyo` must be `"foo"|"bar"`, got `NULL`.
// puyo.foo: The property `puyo.foo` must be `string`, got `integer`.


```

## Licence

MIT Licence
