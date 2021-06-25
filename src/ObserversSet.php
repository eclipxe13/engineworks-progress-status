<?php

declare(strict_types=1);

namespace EngineWorks\ProgressStatus;

use Countable;
use Iterator;
use SplObjectStorage;
use SplObserver;

/**
 * @implements Iterator<int, SplObserver>
 */
class ObserversSet implements Countable, Iterator
{
    /** @var SplObjectStorage<SplObserver, null> */
    private $observers;

    public function __construct()
    {
        $this->observers = new SplObjectStorage();
    }

    public function attach(SplObserver $observer): void
    {
        $this->observers->attach($observer);
    }

    public function detach(SplObserver $observer): void
    {
        $this->observers->detach($observer);
    }

    public function count(): int
    {
        return $this->observers->count();
    }

    public function current()
    {
        /**
         * @var SplObserver
         * @noinspection PhpUnnecessaryLocalVariableInspection
         */
        $current = $this->observers->current();
        return $current;
    }

    public function next(): void
    {
        /** @infection-ignore-all if ommited create an infinite loop */
        $this->observers->next();
    }

    public function key()
    {
        return $this->observers->key();
    }

    public function valid(): bool
    {
        return $this->observers->valid();
    }

    public function rewind(): void
    {
        $this->observers->rewind();
    }
}
