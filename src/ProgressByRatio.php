<?php

declare(strict_types=1);

namespace EngineWorks\ProgressStatus;

use InvalidArgumentException;
use SplObserver;

/** @psalm-suppress PropertyNotSetInConstructor psalm does not recognize that Progress is setting $observers */
class ProgressByRatio extends Progress
{
    /** @var float */
    private $ratio;

    /** @var int */
    private $precision;

    /**
     * ProgressByRatio constructor.
     *
     * @param Status|null $status
     * @param iterable<SplObserver> $observers
     * @param float $ratio
     * @param int $precision
     */
    public function __construct(
        Status $status = null,
        iterable $observers = [],
        float $ratio = 0.01,
        int $precision = 2,
    ) {
        parent::__construct($status, $observers);
        if ($precision < 0) {
            throw new InvalidArgumentException('Precision must be an positive integer');
        }
        $this->precision = $precision;
        $this->ratio = max(round($ratio, $this->precision), 10 ** (-$this->precision));
    }

    /** @noinspection PhpMissingParentCallCommonInspection */
    public function shouldNotifyChange(Status $current, Status $newStatus): bool
    {
        $current = (int) ceil(round($current->getRatio(), $this->precision) / $this->ratio);
        $new = (int) ceil(round($newStatus->getRatio(), $this->precision) / $this->ratio);
        return ($current !== $new);
    }

    public function getRatio(): float
    {
        return $this->ratio;
    }

    public function getPrecision(): int
    {
        return $this->precision;
    }
}
