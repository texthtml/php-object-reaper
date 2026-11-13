<?php declare(strict_types=1);

namespace TH\ObjectReaper\Tests;

use PHPUnit\Framework\TestCase;
use TH\ObjectReaper\Reaper;

final class ReaperTest extends TestCase
{
    public function testCallbackIsCalledWhenSubjectIsDestroyed(): void
    {
        $called = false;

        $subject = (object) [];

        Reaper::watch($subject, static function () use (&$called): void {
            $called = true;
        });

        self::assertFalse($called);

        unset($subject);

        self::assertTrue($called);
    }

    public function testForgetPreventsCallbackFromBeingCalled(): void
    {
        $called = false;

        $subject = (object) [];

        $reaper = Reaper::watch($subject, static function () use (&$called): void {
            $called = true;
        });

        $reaper->forget();

        unset($subject);

        self::assertFalse($called);
    }

    public function testCallbacksAreCalledInRegistrationOrder(): void
    {
        $calls = [];

        $subject = (object) [];

        Reaper::watch($subject, static function () use (&$calls): void {
            $calls[] = 'first';
        });

        Reaper::watch($subject, static function () use (&$calls): void {
            $calls[] = 'second';
        });

        unset($subject);

        self::assertSame(['first', 'second'], $calls);
    }

    public function testWatchAcceptsInvokableObject(): void
    {
        $called = false;

        $listener = new class($called) {
            public function __construct(private bool &$called) {}

            public function __invoke(): void
            {
                $this->called = true;
            }
        };

        $subject = (object) [];

        Reaper::watch($subject, $listener);

        unset($subject);

        self::assertTrue($called);
    }
}
