<?php

declare(strict_types=1);

namespace EngineWorks\ProgressStatus\Tests;

use EngineWorks\ProgressStatus\Tests\Mocks\Observer;
use EngineWorks\ProgressStatus\Tests\Mocks\Subject;
use PHPUnit\Framework\TestCase;

class SplSubjectWithObserversTraitTest extends TestCase
{
    public function testAttachDetach(): void
    {
        $firstObserver = new Observer();
        $secondObserver = new Observer();

        $subject = new Subject();
        $this->assertSame([], iterator_to_array($subject->exposeObservers()));

        // attach observers
        $subject->attach($firstObserver);
        $this->assertSame([$firstObserver], iterator_to_array($subject->exposeObservers()));

        $subject->attach($secondObserver);
        $this->assertSame([$firstObserver, $secondObserver], iterator_to_array($subject->exposeObservers()));

        // detach observers
        $subject->detach($firstObserver);
        $this->assertSame([$secondObserver], iterator_to_array($subject->exposeObservers()));

        // detach observers
        $subject->detach($secondObserver);
        $this->assertSame([], iterator_to_array($subject->exposeObservers()));
    }

    public function testNotify(): void
    {
        // initialize
        $firstObserver = new Observer();
        $secondObserver = new Observer();
        $subject = new Subject();
        $subject->attach($firstObserver);
        $subject->attach($secondObserver);

        // initial state is that observers does not have any subject
        $this->assertNull($firstObserver->subject);
        $this->assertNull($secondObserver->subject);

        // send notification
        $subject->notify();

        // assert that notification set the subject in the observer double
        $this->assertSame($subject, $firstObserver->subject);
        $this->assertSame($subject, $secondObserver->subject);
    }
}
