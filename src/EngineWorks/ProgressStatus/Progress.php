<?php
namespace EngineWorks\ProgressStatus;

class Progress extends AbstractSplSubject implements ProgressInterface
{
    /** @var Status */
    private $status;

    /**
     * Progress constructor.
     *
     * @param Status $initialStatus
     * @param \SplObserver[] $observers
     */
    public function __construct(Status $initialStatus = null, array $observers = [])
    {
        parent::__construct();
        $this->status = $initialStatus ? : Status::make();
        foreach ($observers as $observer) {
            $this->attach($observer);
        }
        $this->notify();
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function increase($message = null, $increase = 1)
    {
        $this->update($message, $this->status->getValue() + $increase);
    }

    public function update(
        $message = null,
        $value = null,
        $total = null,
        $startTime = null,
        $current = null
    ) {
        $newStatus = new Status(
            (null === $current) ? time() : $current,
            (null === $startTime) ? $this->status->getStart() : $startTime,
            (null === $value) ? $this->status->getValue() : $value,
            (null === $total) ? $this->status->getTotal() : $total,
            (null === $message) ? $this->status->getMessage() : $message
        );
        $shouldNotifyChange = $this->shouldNotifyChange($this->status, $newStatus);
        $this->status = $newStatus;
        if ($shouldNotifyChange) {
            $this->notify();
        }
    }

    public function shouldNotifyChange(Status $currentStatus, Status $newstatus)
    {
        return ($currentStatus->getValue() != $newstatus->getValue())
            || ($currentStatus->getMessage() != $newstatus->getMessage())
            || ($currentStatus->getTotal() != $newstatus->getTotal())
            || ($currentStatus->getStart() != $newstatus->getStart());
    }
}
