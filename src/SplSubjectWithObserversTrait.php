<?php

declare(strict_types=1);

namespace EngineWorks\ProgressStatus;

use SplObserver;

/**
 * Implementation of SplSubject interface using the ObserversSet object storage.
 *
 * @implements \SplSubject<\SplObserver>
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
        foreach ($this->getObservers() as $observer) {
            $observer->update($this);
        }
    }

    private function getObservers(): ObserversSet
    {
        return $this->observers;
    }
}
