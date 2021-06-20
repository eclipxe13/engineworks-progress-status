<?php

declare(strict_types=1);

namespace EngineWorks\ProgressStatus;

use SplObserver;

class Progress extends AbstractSplSubject implements ProgressInterface
{
    /** @var Status */
    private $status;

    /**
     * Progress constructor.
     *
     * @param Status|null $initialStatus when null it create an empty State using make method
     * @param iterable<SplObserver> $observers
     */
    public function __construct(Status $initialStatus = null, iterable $observers = [])
    {
        parent::__construct();
        $this->status = $initialStatus ?: Status::make();
        foreach ($observers as $observer) {
            $this->attach($observer);
        }
        $this->notify();
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function increase(string $message = '', int $increase = 1): void
    {
        $this->update($message, $this->status->getValue() + $increase);
    }

    public function update(
        string $message = '',
        int $value = null,
        int $total = null,
        int $startTime = null,
        int $current = null
    ): void {
        $newStatus = new Status(
            $current ?? time(),
            $startTime ?? $this->status->getStart(),
            $value ?? $this->status->getValue(),
            $total ?? $this->status->getTotal(),
            $message ?: $this->status->getMessage()
        );
        $shouldNotifyChange = $this->shouldNotifyChange($this->status, $newStatus);
        $this->status = $newStatus;
        if ($shouldNotifyChange) {
            $this->notify();
        }
    }

    public function shouldNotifyChange(Status $current, Status $newStatus): bool
    {
        return ($current->getValue() !== $newStatus->getValue())
            || ($current->getMessage() !== $newStatus->getMessage())
            || ($current->getTotal() !== $newStatus->getTotal())
            || ($current->getStart() !== $newStatus->getStart());
    }
}
