<?php
declare(strict_types=1);

namespace EngineWorks\ProgressStatus;

use DateInterval;
use DateTimeImmutable;

class Status
{
    /** @var int|float */
    private $value;

    /** @var int|float */
    private $total;

    /** @var int */
    private $current;

    /** @var int */
    private $start;

    /** @var string $message */
    private $message;

    /**
     * Progress Status. This is an immutable object.
     *
     * @param int $current
     * @param int $start
     * @param int $value
     * @param int $total
     * @param string $message
     */
    public function __construct(int $current, int $start, int $value, int $total, string $message)
    {
        $this->current = $current;
        $this->start = $start;
        $this->value = $value;
        $this->total = $total;
        $this->message = $message;
    }

    /**
     * Helper function to create a new object
     *
     * @param int $total
     * @param string $message
     * @param int $value
     * @param int|null $startTime if null then uses the value of time()
     * @param int|null $current if null then uses the value of time()
     * @return Status
     */
    public static function make(int $total = 0, string $message = '', int $value = 0, int $startTime = null, int $current = null): Status
    {
        $now = time();
        return new self($current ? : $now, $startTime ? : $now, $value, $total, $message);
    }

    /**
     * @return int
     */
    public function getStart(): int
    {
        return $this->start;
    }

    /**
     * @return float|int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return float|int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function getCurrent(): int
    {
        return $this->current;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return float current value in seconds elapsed
     */
    public function getSpeed()
    {
        $elapsed = $this->getSecondsElapsed();
        if (0 === $elapsed) {
            return 0.0;
        }
        return $this->value / $elapsed;
    }

    /**
     * Get the ratio between current value and total, if total is zero it returns zero
     *
     * @return float
     */
    public function getRatio(): float
    {
        if ($this->total == 0) {
            return 0.0;
        }
        return floatval($this->value / $this->total);
    }

    /**
     * Get the difference between the total and current value
     *
     * @return int|float
     */
    public function getRemain()
    {
        return $this->total - $this->value;
    }

    /**
     * @return int
     */
    public function getEstimatedTimeOfEnd(): ?int
    {
        $speed = $this->getSpeed();
        $remain = $this->getRemain();
        if (0 == $remain) {
            return time();
        }
        if (abs($speed) < 0.0001) {
            return null;
        }
        return $this->current + (int) round($remain * $speed, 0);
    }

    /**
     *
     * @return int
     */
    public function getSecondsElapsed(): int
    {
        return $this->current - $this->start;
    }

    /**
     * Get elapsed time between start time and current time
     *
     * @return DateInterval
     */
    public function getIntervalElapsed(): DateInterval
    {
        return (new DateTimeImmutable('@' . $this->start))->diff(new DateTimeImmutable('@' . $this->current));
    }
}
