# Object Reaper: here for your objects when they pass away

[![Latest Stable Version](https://img.shields.io/packagist/v/texthtml/object-reaper?logo=packagist)](https://packagist.org/packages/texthtml/object-reaper)
[![Supported PHP Versions](https://img.shields.io/packagist/dependency-v/texthtml/object-reaper/php?logo=php&color=777bb4)](https://packagist.org/packages/texthtml/object-reaper)
[![License](https://img.shields.io/packagist/l/texthtml/object-reaper)](LICENSE)
[![Tests](https://github.com/texthtml/php-object-reaper/actions/workflows/test.yml/badge.svg)](https://github.com/texthtml/php-object-reaper/actions/workflows/test.yml)
[![Codecov](https://img.shields.io/codecov/c/github/texthtml/php-object-reaper?logo=codecov)](https://codecov.io/gh/texthtml/php-object-reaper)

Let you register callbacks that will be called when objects are destroyed.

# Installation

```bash
composer req texthtml/object-reaper
```

Requires PHP 8.2+.

# Usage

```php
$a = (object) [];

// Attach a callback to any object
// It will be called when the object is destroyed

Reaper::watch($a, function () { echo "Good Bye"; });

// "Good bye" will be printed when $a is destroyed
```

## Detaching

`Reaper::watch()` returns a reaper instance. Call `forget()` on it to detach
the callback: it will no longer be called when the object is destroyed.

```php
$a = (object) [];

$reaper = Reaper::watch($a, function () { echo "Good Bye"; });
$reaper->forget();

unset($a);
// prints nothing
```

## Multiple callbacks

You can attach several callbacks to the same object. They are called in the
order they were registered.

```php
$a = (object) [];

Reaper::watch($a, function () { echo "Good"; });
Reaper::watch($a, function () { echo " Bye"; });

unset($a);
// prints "Good Bye"
```
