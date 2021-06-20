<?php

declare(strict_types=1);

namespace EngineWorks\ProgressStatus\Tests;

use EngineWorks\ProgressStatus\ProgressByRatio;
use EngineWorks\ProgressStatus\Status;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ProgressByRatioTest extends TestCase
{
    public function testConstuctor(): void
    {
        $ratio = 0.01;
        $precision = 2;
        $progress = new ProgressByRatio();
        $this->assertEqualsWithDelta($ratio, $progress->getRatio(), 0.01);
        $this->assertSame($precision, $progress->getPrecision());
    }

    public function testConstuctorWithValues(): void
    {
        $ratio = 0.1;
        $precision = 1;
        $progress = new ProgressByRatio(Status::make(), [], $ratio, $precision);
        $this->assertEqualsWithDelta($ratio, $progress->getRatio(), 0.01);
        $this->assertSame($precision, $progress->getPrecision());
    }

    /** @return array<string, mixed[]> */
    public function providerInvalidPrecision(): array
    {
        return [
            'zero' => [0],
            'lower than zero' => [-1],
        ];
    }

    /**
     * @param int $precision
     * @dataProvider providerInvalidPrecision
     */
    public function testInvalidPrecision(int $precision): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/.*precision.*/i');
        new ProgressByRatio(Status::make(), [], 0.1, $precision);
    }

    /** @return array<string, mixed[]> */
    public function providerInvalidRatio(): array
    {
        return [
            'zero' => [0],
            'lower than zero' => [-1],
            'lower than minimum precision of 2' => [0.001],
        ];
    }

    /**
     * @param float $ratio
     * @dataProvider providerInvalidRatio
     */
    public function testInvalidRatio(float $ratio): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/.*ratio.*/i');
        new ProgressByRatio(Status::make(), [], $ratio, 2);
    }

    public function testShouldNotifyChangePossitive(): void
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
