# Object Reaper: here for your objects when they pass away

Let you register callbacks that will be called when objects are destroyed.

# Installation

```bash
composer req texthtml/object-reaper
```

# Usage

```php
$a = (object) [];

// Attach a callback to any object
// It will be called when the object is destroyed

Reaper::watch($a, function () { echo "Good Bye"; });

// "Good bye" will be printed when $a is destroyed
```
