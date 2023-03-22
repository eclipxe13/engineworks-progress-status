<?php

declare(strict_types=1);

namespace EngineWorks\ProgressStatus;

use SplObserver;
use SplSubject;

class ObserverCallable implements SplObserver
{
    /** @var callable(SplSubject):void */
    private $callable;

    /**
     * ObserverCallable constructor.
     *
     * @param callable(SplSubject):void $callable
     */
    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    public function update(SplSubject $subject): void
    {
        call_user_func($this->callable, $subject);
    }

    /**
     * @return callable(SplSubject):void
     */
    public function getCallable(): callable
    {
        return $this->callable;
    }
}
