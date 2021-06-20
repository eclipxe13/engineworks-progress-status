<?php
declare(strict_types=1);

namespace EngineWorks\ProgressStatus;

class ProgressByRatio extends Progress
{
    /** @var float */
    private $ratio;

    /** @var int */
    private $precision;

    /**
     * ProgressByRatio constructor.
     *
     * @param Status $status
     * @param \SplObserver[] $observers
     * @param float $ratio
     * @param int $precision
     */
    public function __construct(Status $status = null, array $observers = [], float $ratio = 0.01, int $precision = 2)
    {
        parent::__construct($status, $observers);
        $this->setPrecision($precision);
        $this->setRatio($ratio);
    }

    public function shouldNotifyChange(Status $currentStatus, Status $newStatus): bool
    {
        $current = (int) ceil(round($currentStatus->getRatio(), $this->precision) / $this->ratio);
        $new = (int) ceil(round($newStatus->getRatio(), $this->precision) / $this->ratio);
        return ($current !== $new);
    }

    /**
     * @return float
     */
    public function getRatio(): float
    {
        return $this->ratio;
    }

    /**
     * @return int
     */
    public function getPrecision(): int
    {
        return $this->precision;
    }

    /**
     * @param float $ratio
     */
    protected function setRatio(float $ratio): void
    {
        if (! is_int($ratio) && ! is_float($ratio)) {
            throw new \InvalidArgumentException('Ratio is not a float value');
        }
        $ratio = round($ratio, $this->precision);
        if ($ratio < pow(10, - $this->precision)) {
            throw new \InvalidArgumentException('Ratio change is lower than minimum value of precision');
        }
        $this->ratio = $ratio;
    }

    /**
     * @param int $precision
     */
    protected function setPrecision(int $precision): void
    {
        if (! is_int($precision) || 0 === $precision) {
            throw new \InvalidArgumentException('Precision must be an positive integer greater or equals to zero');
        }
        $this->precision = $precision;
    }
}
