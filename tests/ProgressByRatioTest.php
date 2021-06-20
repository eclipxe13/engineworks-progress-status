<?php
namespace EngineWorks\ProgressStatus\Tests;

use EngineWorks\ProgressStatus\ProgressByRatio;
use EngineWorks\ProgressStatus\Status;
use PHPUnit\Framework\TestCase;

class ProgressByRatioTest extends TestCase
{
    public function testConstuctor()
    {
        $ratio = 0.01;
        $precision = 2;
        $progress = new ProgressByRatio();
        $this->assertEqualsWithDelta($ratio, $progress->getRatio(), 0.01);
        $this->assertSame($precision, $progress->getPrecision());
    }

    public function testConstuctorWithValues()
    {
        $ratio = 0.1;
        $precision = 1;
        $progress = new ProgressByRatio(Status::make(), [], $ratio, $precision);
        $this->assertEqualsWithDelta($ratio, $progress->getRatio(), 0.01);
        $this->assertSame($precision, $progress->getPrecision());
    }

    public function providerInvalidPrecision()
    {
        return [[0], [-1], [0.1], [''], [null], [false]];
    }

    /**
     * @param $precision
     * @dataProvider providerInvalidPrecision
     */
    public function testInvalidPrecision($precision)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/.*precision.*/i');
        new ProgressByRatio(Status::make(), [], 0.1, $precision);
    }

    public function providerInvalidRatio()
    {
        return [[0], [-1], [0.0001], [0.004], [''], [null], [false]];
    }

    /**
     * @param $ratio
     * @dataProvider providerInvalidRatio
     */
    public function testInvalidRatio($ratio)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/.*ratio.*/i');
        new ProgressByRatio(Status::make(), [], $ratio, 2);
    }

    public function testShouldNotifyChangePossitive()
    {
        $ratio = 0.05; // 5%
        $precision = 2; // two decimal places
        $statusSix = Status::make(100, '', 6); // 6%
        $statusNine = Status::make(100, '', 9); // 9%
        $statusTen = Status::make(100, '', 10); // 10%
        $statusEleven = Status::make(100, '', 11); // 11%
        $progress = new ProgressByRatio(Status::make(), [], $ratio, $precision);
        $this->assertFalse($progress->shouldNotifyChange($statusSix, $statusNine));
        $this->assertFalse($progress->shouldNotifyChange($statusSix, $statusTen));
        $this->assertFalse($progress->shouldNotifyChange($statusNine, $statusTen));
        $this->assertTrue($progress->shouldNotifyChange($statusSix, $statusEleven));
        $this->assertTrue($progress->shouldNotifyChange($statusTen, $statusEleven));
    }
}
