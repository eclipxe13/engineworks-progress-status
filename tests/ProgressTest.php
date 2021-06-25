<?php

declare(strict_types=1);

namespace EngineWorks\ProgressStatus\Tests;

use EngineWorks\ProgressStatus\Progress;
use EngineWorks\ProgressStatus\Status;
use EngineWorks\ProgressStatus\Tests\Mocks\Observer;
use PHPUnit\Framework\TestCase;
use SplSubject;

class ProgressTest extends TestCase
{
    public function testConstructorWithDefaults(): void
    {
        $now = time();
        $progress = new Progress();
        $this->assertInstanceOf(SplSubject::class, $progress);
        $this->assertInstanceOf(Status::class, $progress->getStatus());
        $status = $progress->getStatus();
        $this->assertSame(0, $status->getValue());
        $this->assertSame(0, $status->getTotal());
        $this->assertSame('', $status->getMessage());
        $this->assertSame($now, $status->getStart());
        $this->assertSame($now, $status->getCurrent());
    }

    public function testConstructWithValues(): void
    {
        $start = strtotime('2017-01-13 15:00:00');
        $current = strtotime('2017-01-13 15:01:00');
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

    public function testNotify(): void
    {
        $progress = new Progress();
        $observer = new Observer();
        $progress->attach($observer);
        $progress->notify();
        $this->assertSame($observer->subject, $progress);
    }

    public function testIncrease(): void
    {
        $progress = new Progress();
        $progress->increase('two', 2);
        $status = $progress->getStatus();
        $this->assertSame(2, $status->getValue());
        $this->assertSame('two', $status->getMessage());
    }

    public function testUpdateWithNoValues(): void
    {
        $start = strtotime('2017-01-13 15:00:00');
        $current = strtotime('2017-01-13 15:01:00');
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

    public function testUpdateWithValues(): void
    {
        $firstStatus = Status::make(5, 'init', 1, strtotime('2017-01-13 15:00:00'), strtotime('2017-01-13 15:01:00'));
        $progress = new Progress($firstStatus);
        $newStatus = Status::make(6, 'updated', 2, strtotime('2017-01-13 15:00:01'), strtotime('2017-01-13 15:01:01'));
        $progress->update(
            $newStatus->getMessage(),
            $newStatus->getValue(),
            $newStatus->getTotal(),
            $newStatus->getStart(),
            $newStatus->getCurrent(),
        );
        $this->assertNotEquals($firstStatus, $progress->getStatus());
        $this->assertEquals($newStatus, $progress->getStatus());
    }

    /** @return array<string, mixed[]> */
    public function providerShouldNofityChange(): array
    {
        $now = time();
        return [
            'no change' => [
                false,
                Status::make(2, 'foo', 0, $now, $now),
                Status::make(2, 'foo', 0, $now, $now),
            ],
            'change value' => [
                true,
                Status::make(2, 'foo', 0, $now, $now),
                Status::make(2, 'foo', 1, $now, $now),
            ],
            'change message' => [
                true,
                Status::make(2, 'foo', 0, $now, $now),
                Status::make(2, 'bar', 0, $now, $now),
            ],
            'change total' => [
                true,
                Status::make(2, 'foo', 0, $now, $now),
                Status::make(3, 'foo', 0, $now, $now),
            ],
            'change start' => [
                true,
                Status::make(2, 'foo', 0, $now, $now),
                Status::make(2, 'foo', 0, $now + 1, $now),
            ],
            'change current time do not notify' => [
                false,
                Status::make(2, 'foo', 0, $now, $now),
                Status::make(2, 'foo', 0, $now, $now + 1),
            ],
        ];
    }

    /** @dataProvider providerShouldNofityChange */
    public function testShouldNofityChange(bool $expected, Status $first, Status $second): void
    {
        $sometime = time() - 1;
        $progress = new Progress(Status::make(2, 'init', 0, $sometime, $sometime));
        $this->assertSame($expected, $progress->shouldNotifyChange($first, $second));
    }
}
