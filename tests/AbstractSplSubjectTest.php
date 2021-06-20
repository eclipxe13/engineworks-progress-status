<?php
namespace EngineWorks\ProgressStatus\Tests;

use PHPUnit\Framework\TestCase;
use EngineWorks\ProgressStatus\Tests\Mocks\Observer;
use EngineWorks\ProgressStatus\Tests\Mocks\Subject;

class AbstractSplSubjectTest extends TestCase
{
    public function testNotify()
    {
        // initialize
        $firstObserver = new Observer();
        $secondObserver = new Observer();
        $subject = new Subject();

        // attachObservers
        $subject->attach($firstObserver);
        $subject->attach($secondObserver);
        $this->assertNull($firstObserver->subject);
        $this->assertNull($secondObserver->subject);

        // send notification
        $subject->notify();

        // asset that notification actually work
        $this->assertSame($subject, $firstObserver->subject);
        $this->assertSame($subject, $secondObserver->subject);

        // detach observers
        $subject->detach($firstObserver);
        $this->assertCount(1, $subject->exposeObservers());
    }
}
