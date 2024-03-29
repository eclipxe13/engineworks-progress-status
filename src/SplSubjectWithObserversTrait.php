<?php

declare(strict_types=1);

namespace EngineWorks\ProgressStatus;

use LogicException;
use SplObserver;
use SplSubject;

/**
 * Implementation of SplSubject interface using the ObserversSet object storage.
 */
trait SplSubjectWithObserversTrait
{
    /** @var ObserversSet */
    private $observers;

    private function constructSplSubjectWithObservers(): void
    {
        $this->observers = new ObserversSet();
    }

    public function attach(SplObserver $observer): void
    {
        $this->observers->attach($observer);
    }

    public function detach(SplObserver $observer): void
    {
        $this->observers->detach($observer);
    }

    public function notify(): void
    {
        if (! $this instanceof SplSubject) {
            /** @psalm-var object $this Psalm identify $this as empty-mixed */
            throw new LogicException(sprintf('Object %s is not an instance of SplSubject', get_class($this)));
        }
        foreach ($this->getObservers() as $observer) {
            $observer->update($this);
        }
    }

    private function getObservers(): ObserversSet
    {
        return $this->observers;
    }
}
