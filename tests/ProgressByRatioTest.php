<?php

declare(strict_types=1);

namespace EngineWorks\ProgressStatus\Tests;

use EngineWorks\ProgressStatus\ProgressByRatio;
use EngineWorks\ProgressStatus\Status;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ProgressByRatioTest extends TestCase
{
    public function testConstructor(): void
    {
        $ratio = 0.01;
        $precision = 2;
        $progress = new ProgressByRatio();
        $this->assertEqualsWithDelta($ratio, $progress->getRatio(), 0.01);
        $this->assertSame($precision, $progress->getPrecision());
    }

    public function testConstructorWithValues(): void
    {
        $ratio = 0.1;
        $precision = 1;
        $status = Status::make();
        $progress = new ProgressByRatio($status, [], $ratio, $precision);
        $this->assertSame($status, $progress->getStatus());
        $this->assertEqualsWithDelta($ratio, $progress->getRatio(), 0.01);
        $this->assertSame($precision, $progress->getPrecision());
    }

    public function testPrecisionLowerThanZeroThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Precision must be an positive integer');
        new ProgressByRatio(Status::make(), [], 0.1, -1);
    }

    /**
     * @param int $precision
     * @testWith [0]
     *           [1]
     */
    public function testPrecisionMustBeAPositiveInteger(int $precision): void
    {
        $progress = new ProgressByRatio(Status::make(), [], 1, $precision);
        $this->assertSame($precision, $progress->getPrecision());
    }

    /** @return array<string, array<int|float>> */
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
        $progressByRatio = new ProgressByRatio(Status::make(), [], $ratio, 2);
        $this->assertEqualsWithDelta(0.01, $progressByRatio->getRatio(), 0.001);
    }

    public function testShouldNotifyChangePositive(): void
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
