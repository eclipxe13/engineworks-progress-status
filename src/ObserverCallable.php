<?php

declare(strict_types=1);

namespace EngineWorks\ProgressStatus;

use SplObserver;
use SplSubject;

class ObserverCallable implements SplObserver
{
    /** @var callable */
    private $callable;

    /**
     * ObserverCallable constructor.
     *
     * @param callable $callable
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
     * @return callable
     */
    public function getCallable(): callable
    {
        return $this->callable;
    }
}
