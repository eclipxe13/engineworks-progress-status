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

    public function attach(SplObserver $observer)
    {
        $this->observers->attach($observer);
    }

    public function detach(SplObserver $observer)
    {
        $this->observers->detach($observer);
    }

    public function notify()
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
