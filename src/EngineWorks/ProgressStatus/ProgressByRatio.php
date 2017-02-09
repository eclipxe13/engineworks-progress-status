<?php
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
    public function __construct(Status $status, array $observers = [], $ratio = 0.01, $precision = 2)
    {
        parent::__construct($status, $observers);
        $this->ratio = $ratio;
        $this->precision = $precision;
    }

    public function shouldNotifyChange(Status $currentStatus, Status $newstatus)
    {
        return round($currentStatus->getRatio() - $newstatus->getRatio() - $this->ratio, $this->precision) >= 0.0;
    }
}
