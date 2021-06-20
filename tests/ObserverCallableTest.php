<?php
declare(strict_types=1);

namespace EngineWorks\ProgressStatus\Tests;

use EngineWorks\ProgressStatus\ObserverCallable;
use PHPUnit\Framework\TestCase;
use EngineWorks\ProgressStatus\Tests\Mocks\Subject;

class ObserverCallableTest extends TestCase
{
    public function testConstructor()
    {
        $callable = function () {
            return;
        };
        $observer = new ObserverCallable($callable);
        $this->assertInstanceOf(\SplObserver::class, $observer);
        $this->assertSame($callable, $observer->getCallable());
    }

    public function testUpdate()
    {
        $subject = new Subject();
        $expectedMessage = 'This is the expected message';
        $retrievedMessage = '';
        $callable = function (\SplSubject $subject) use (&$retrievedMessage) {
            /* @var Subject $subject */
            $retrievedMessage = $subject->foo;
        };
        $observer = new ObserverCallable($callable);
        $subject->foo = $expectedMessage;
        $observer->update($subject);
        $this->assertEquals($retrievedMessage, $expectedMessage);
    }
}
