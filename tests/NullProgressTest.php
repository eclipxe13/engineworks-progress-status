<?php
declare(strict_types=1);

namespace EngineWorks\ProgressStatus\Tests;

use EngineWorks\ProgressStatus\NullProgress;
use EngineWorks\ProgressStatus\ProgressInterface;
use EngineWorks\ProgressStatus\Status;
use PHPUnit\Framework\TestCase;

class NullProgressTest extends TestCase
{
    public function testConstruct()
    {
        $progress = new NullProgress();
        $this->assertInstanceOf(ProgressInterface::class, $progress);
        $this->assertInstanceOf(Status::class, $progress->getStatus());
        $this->assertSame(false, $progress->shouldNotifyChange($progress->getStatus(), Status::make(10)));
    }

    public function testConstructPreservesTheStatus()
    {
        $status = Status::make();
        $progress = new NullProgress($status);
        $this->assertSame($status, $progress->getStatus());
    }

    public function testIncreaseDoesNotChangeTheStatus()
    {
        $status = Status::make();
        $progress = new NullProgress($status);
        $this->assertSame($status, $progress->getStatus());
        $progress->increase();
        $this->assertSame($status, $progress->getStatus());
        $this->assertSame(0, $status->getValue());
    }
}
