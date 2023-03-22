<?php

declare(strict_types=1);

namespace EngineWorks\ProgressStatus\Tests;

use EngineWorks\ProgressStatus\ObserverCallable;
use EngineWorks\ProgressStatus\Tests\Mocks\Subject;
use PHPUnit\Framework\TestCase;
use SplObserver;
use SplSubject;

class ObserverCallableTest extends TestCase
{
    public function testConstructor(): void
    {
        $callable = function (SplSubject $_): void {
        };
        $observer = new ObserverCallable($callable);
        $this->assertInstanceOf(SplObserver::class, $observer);
        $this->assertSame($callable, $observer->getCallable());
    }

    public function testUpdate(): void
    {
        $subject = new Subject();
        $expectedMessage = 'This is the expected message';
        $retrievedMessage = '';
        $callable = function (SplSubject $subject) use (&$retrievedMessage): void {
            /** @var Subject $subject */
            $retrievedMessage = $subject->foo;
        };
        $observer = new ObserverCallable($callable);
        $subject->foo = $expectedMessage;
        $observer->update($subject);
        $this->assertEquals($retrievedMessage, $expectedMessage);
    }
}
