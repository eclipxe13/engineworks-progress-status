<?php

declare(strict_types=1);

namespace EngineWorks\ProgressStatus\Tests;

use DateInterval;
use EngineWorks\ProgressStatus\Progress;
use EngineWorks\ProgressStatus\Status;
use EngineWorks\ProgressStatus\Tests\Mocks\Observer;
use PHPUnit\Framework\TestCase;

class StatusTest extends TestCase
{
    public function testConstruct(): void
    {
        $startTime = strtotime('2017-01-13 8:00:00');
        $currentTime = strtotime('2017-01-13 8:00:16');
        $futureTime = strtotime('2017-01-13 8:00:48');
        $elapsed = 16;
        $value = 4;
        $total = 12;
        $speed = 0.25;
        $ratio = 0.33;
        $remain = $total - $value;
        $message = 'dummy message';

        $status = new Status($currentTime, $startTime, $value, $total, $message);
        $this->assertSame($currentTime, $status->getCurrent());
        $this->assertSame($startTime, $status->getStart());
        $this->assertSame($value, $status->getValue());
        $this->assertSame($total, $status->getTotal());
        $this->assertSame($message, $status->getMessage());

        $this->assertEquals($elapsed, $status->getSecondsElapsed());
        $this->assertEquals(new DateInterval('PT16S'), $status->getIntervalElapsed());
        $this->assertEquals($remain, $status->getRemain());
        $this->assertEquals(date('c', $futureTime), date('c', $status->getEstimatedTimeOfEnd() ?? 0));
        $this->assertEqualsWithDelta($speed, $status->getSpeed(), 0.0001);
        $this->assertEqualsWithDelta($ratio, round($status->getRatio(), 2), 0.001);
    }

    public function testProgressUseCase(): void
    {
        $addresses = ['foo@example.com', 'bar@example.com', 'baz@example.com'];
        $observer = new Observer();
        $progress = new Progress(Status::make(count($addresses), 'Preparing to send messages'), [$observer]);
        foreach ($addresses as $address) {
            $progress->increase('Sending mail to ' . $address);
        }
        $progress->update('Finish', null);

        $expectedMessages = [
            'Preparing to send messages [0/3]',
            'Sending mail to foo@example.com [1/3]',
            'Sending mail to bar@example.com [2/3]',
            'Sending mail to baz@example.com [3/3]',
            'Finish [3/3]',
        ];
        $this->assertEquals($expectedMessages, $observer->updates);
    }

    public function testMakeWithNoValues(): void
    {
        $status = Status::make();
        $this->assertEquals(0, $status->getTotal());
        $this->assertEquals(0, $status->getValue());
        $this->assertNotEquals(0, $status->getCurrent());
        $this->assertNotEquals(0, $status->getStart());
        $this->assertEquals($status->getCurrent(), $status->getStart());
        $this->assertEquals($status->getCurrent(), $status->getEstimatedTimeOfEnd());
        $this->assertEquals(0, $status->getSecondsElapsed());
        $this->assertEquals(0, $status->getSpeed());
        $this->assertEquals(0, $status->getRatio());
    }

    public function testEstimatedTimeOfEnd(): void
    {
        $timeToEndOneTask = 10; // seconds
        $startTime = strtotime('2017-01-01 8:00:00');
        $currentTime = strtotime("$timeToEndOneTask seconds", $startTime); // speed is 1 / 10secs
        $status = Status::make(20, '', 1, $startTime, $currentTime);
        $this->assertSame(
            date('c', $currentTime + ($status->getRemain() * $timeToEndOneTask)),
            date('c', $status->getEstimatedTimeOfEnd() ?? 0),
        );
    }

    public function testEstimatedTimeOfEndReturnMaxETA(): void
    {
        $startTime = strtotime('2017-01-01 8:00:00');
        $currentTime = strtotime('+ 24 hours', $startTime); // speed is 1 / day
        $expectedTime = strtotime('+ 48 hours', $startTime);
        $status = Status::make(2, '', 1, $startTime, $currentTime);
        $this->assertSame(
            date('c', $expectedTime),
            date('c', $status->getEstimatedTimeOfEnd() ?? 0),
        );
    }

    public function testEstimatedTimeOfEndReturnNullOnInfinite(): void
    {
        $startTime = strtotime('2017-01-01 8:00:00');
        $currentTime = strtotime('+ 24 hours 1 second', $startTime); // speed is lower than 1 / day
        $status = Status::make(1000, '', 1, $startTime, $currentTime);
        $this->assertNull($status->getEstimatedTimeOfEnd());
    }
}
