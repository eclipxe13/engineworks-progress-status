<?php
namespace EngineWorks\ProgressStatus\Tests;

use EngineWorks\ProgressStatus\Progress;
use EngineWorks\ProgressStatus\Status;
use PHPUnit\Framework\TestCase;
use EngineWorks\ProgressStatus\Tests\Mocks\Observer;

class ProgressTest extends TestCase
{
    public function testConstructorWithDefaults()
    {
        $now = time();
        $progress = new Progress();
        $this->assertInstanceOf(\SplSubject::class, $progress);
        $this->assertInstanceOf(Status::class, $progress->getStatus());
        $status = $progress->getStatus();
        $this->assertSame(0, $status->getValue());
        $this->assertSame(0, $status->getTotal());
        $this->assertSame('', $status->getMessage());
        $this->assertSame($now, $status->getStart());
        $this->assertSame($now, $status->getCurrent());
    }

    public function testConstructWithValues()
    {
        $start = new \DateTimeImmutable('2017-01-13 15:00:00');
        $current = new \DateTimeImmutable('2017-01-13 15:01:00');
        $total = 5;
        $message = 'init';
        $value = 1;
        $progress = new Progress(Status::make($total, $message, $value, $start, $current));
        $status = $progress->getStatus();
        $this->assertSame($value, $status->getValue());
        $this->assertSame($total, $status->getTotal());
        $this->assertSame($message, $status->getMessage());
        $this->assertSame($start, $status->getStart());
        $this->assertSame($current, $status->getCurrent());
    }

    public function testNotify()
    {
        $progress = new Progress();
        $observer = new Observer();
        $progress->attach($observer);
        $progress->notify();
        $this->assertSame($observer->subject, $progress);
    }

    public function testIncrease()
    {
        $progress = new Progress();
        $progress->increase('two', 2);
        $status = $progress->getStatus();
        $this->assertSame(2, $status->getValue());
        $this->assertSame('two', $status->getMessage());
    }

    public function testUpdateWithNoValues()
    {
        $start = new \DateTimeImmutable('2017-01-13 15:00:00');
        $current = new \DateTimeImmutable('2017-01-13 15:01:00');
        $total = 5;
        $message = 'init';
        $value = 1;
        $progress = new Progress(Status::make($total, $message, $value, $start, $current));
        $status = $progress->getStatus();
        $progress->update();
        $newStatus = $progress->getStatus();
        $this->assertEquals($status->getValue(), $newStatus->getValue());
        $this->assertEquals($status->getTotal(), $newStatus->getTotal());
        $this->assertEquals($status->getMessage(), $newStatus->getMessage());
        $this->assertEquals($status->getStart(), $newStatus->getStart());
        $this->assertNotEquals($status->getCurrent(), $newStatus->getCurrent());
    }
}
