<?php

declare(strict_types=1);

namespace EngineWorks\ProgressStatus;

use DateInterval;
use DateTimeImmutable;

class Status
{
    /** This is the minumum speed before declare undefined ETA (1 day) */
    private const MINIMUM_SPEED = 1 / 86400;

    /** @var int */
    private $value;

    /** @var int */
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
     *
     * @return self
     */
    public static function make(
        int $total = 0,
        string $message = '',
        int $value = 0,
        ?int $startTime = null,
        ?int $current = null
    ): self {
        $now = time();
        return new self($current ?: $now, $startTime ?: $now, $value, $total, $message);
    }

    public function getStart(): int
    {
        return $this->start;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getCurrent(): int
    {
        return $this->current;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Get the current value in seconds elapsed
     *
     * @return float
     */
    public function getSpeed(): float
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
        if (0 == $this->total) {
            return 0.0;
        }
        return floatval($this->value / $this->total);
    }

    /**
     * Get the difference between the total and current value
     *
     * @return int
     */
    public function getRemain(): int
    {
        return $this->total - $this->value;
    }

    /**
     * Return the estimated time of end, NULL if too high
     * @return int|null
     */
    public function getEstimatedTimeOfEnd(): ?int
    {
        $speed = $this->getSpeed();
        $remain = $this->getRemain();
        if (0 === $remain) {
            return time();
        }
        $minimumSpeed = self::MINIMUM_SPEED;
        if (abs($speed) <= $minimumSpeed) {
            return null;
        }
        return $this->current + intval($remain / $speed);
    }

    public function getSecondsElapsed(): int
    {
        return $this->current - $this->start;
    }

    /**
     * Get elapsed time between start time and current time
     *
     * @return DateInterval
     * @noinspection PhpDocMissingThrowsInspection
     */
    public function getIntervalElapsed(): DateInterval
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return (new DateTimeImmutable('@' . $this->start))->diff(new DateTimeImmutable('@' . $this->current));
    }
}
