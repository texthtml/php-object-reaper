<?php declare(strict_types=1);

namespace TH\ObjectReaper;

final class Reaper
{
    /** @var \WeakMap<object,list<self>> */
    private static \WeakMap $dd;

    private function __construct(private readonly \Closure $callback) {}

    /**
     * Attach a callback to an object to be called when that object is destroyed.
     *
     * ```php
     * $a = (object) [];
     *
     * Reaper::watch($a, function () { echo "Good Bye\n"; });
     *
     * // First
     * // @prints Hello
     * echo "Hello\n";
     *
     * // When we force destroy $a, then
     * // @prints Good Bye
     * unset($a);
     *
     * // And at last
     * // @prints The end
     * echo "The end";
     * ```
     *
     * ```php
     * $a = (object) [];
     *
     * Reaper::watch($a, function () { echo "Good"; });
     * Reaper::watch($a, function () { echo " Bye"; });
     *
     * // @prints Good Bye
     * ```
     *
     * ```php
     * $a = (object) [];
     * $b = (object) [];
     *
     * Reaper::watch($b, function () { echo "Good"; });
     * Reaper::watch($a, function () { echo " Bye"; });
     *
     * unset($b);
     * // @prints Good Bye
     * ```
     *
     * @param callable(): void $callback
     */
    public static function watch(object $subject, callable $callback): void {
        self::$dd ??= new \WeakMap();

        self::$dd[$subject] ??= [];

        self::$dd[$subject][] = new self(\Closure::fromCallable($callback));
    }

    /** @nodoc */
    public function __destruct() {
        ($this->callback)();
    }
}
