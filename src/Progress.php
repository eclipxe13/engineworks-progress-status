<?php
namespace EngineWorks\ProgressStatus;

class Progress extends AbstractSplSubject implements ProgressInterface
{
    /** @var Status */
    private $status;

    /**
     * Progress constructor.
     *
     * @param Status|null $initialStatus when null it create an empty State using make method
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
            $current ?? time(),
            $startTime ?? $this->status->getStart(),
            $value ?? $this->status->getValue(),
            $total ?? $this->status->getTotal(),
            $message ?? $this->status->getMessage()
        );
        $shouldNotifyChange = $this->shouldNotifyChange($this->status, $newStatus);
        $this->status = $newStatus;
        if ($shouldNotifyChange) {
            $this->notify();
        }
    }

    public function shouldNotifyChange(Status $currentStatus, Status $newStatus)
    {
        return ($currentStatus->getValue() != $newStatus->getValue())
            || ($currentStatus->getMessage() != $newStatus->getMessage())
            || ($currentStatus->getTotal() != $newStatus->getTotal())
            || ($currentStatus->getStart() != $newStatus->getStart());
    }
}
