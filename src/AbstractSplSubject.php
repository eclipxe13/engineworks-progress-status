<?php

declare(strict_types=1);

namespace EngineWorks\ProgressStatus;

use SplObserver;
use SplSubject;

abstract class AbstractSplSubject implements SplSubject
{
    /**
     * @var ObserversSet
     */
    private $observers;

    public function __construct()
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

    /**
     * @return ObserversSet|SplObserver[]
     */
    protected function getObservers(): ObserversSet
    {
        return $this->observers;
    }
}
