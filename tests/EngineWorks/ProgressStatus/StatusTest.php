<?php
namespace Tests\EngineWorks\ProgressStatus;

use EngineWorks\ProgressStatus\Progress;
use EngineWorks\ProgressStatus\Status;
use PHPUnit\Framework\TestCase;
use Tests\EngineWorks\ProgressStatus\Mocks\Observer;

class StatusTest extends TestCase
{
    public function testConstruct()
    {
        $startTime = strtotime('2017-01-13 8:00:00');
        $currentTime = strtotime('2017-01-13 8:00:16');
        $futureTime = strtotime('2017-01-13 8:00:18');
        $elapsed = 16;
        $value = 4;
        $total = 12;
        $speed = 0.25;
        $remain = $total - $value;
        $message = 'dummy message';

        $status = new Status($currentTime, $startTime, $value, $total, $message);
        $this->assertSame($currentTime, $status->getCurrent());
        $this->assertSame($startTime, $status->getStart());
        $this->assertSame($value, $status->getValue());
        $this->assertSame($total, $status->getTotal());
        $this->assertSame($message, $status->getMessage());

        $this->assertEquals($elapsed, $status->getSecondsElapsed());
        $this->assertEquals(new \DateInterval('PT16S'), $status->getIntervalElapsed());
        $this->assertEquals($remain, $status->getRemain());
        $this->assertEquals($futureTime, $status->getEstimatedTimeOfEnd());
        $this->assertEquals($speed, $status->getSpeed(), '', 0.0001);
    }

    public function testProgressUseCase()
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
}
