<?php
namespace EngineWorks\ProgressStatus;

use SplSubject;

class ObserverCallable implements \SplObserver
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

    public function update(SplSubject $subject)
    {
        call_user_func($this->callable, $subject);
    }

    /**
     * @return callable
     */
    public function getCallable()
    {
        return $this->callable;
    }
}
