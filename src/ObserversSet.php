<?php
declare(strict_types=1);

namespace EngineWorks\ProgressStatus;

use Countable;
use Iterator;
use SplObjectStorage;
use SplObserver;

class ObserversSet implements Countable, Iterator
{
    /** @var SplObjectStorage */
    private $observers;

    public function __construct()
    {
        $this->observers = new SplObjectStorage();
    }

    public function attach(SplObserver $observer)
    {
        $this->observers->attach($observer);
    }

    public function detach(SplObserver $observer)
    {
        $this->observers->detach($observer);
    }

    public function count(): int
    {
        return $this->observers->count();
    }

    public function current()
    {
        return $this->observers->current();
    }

    public function next()
    {
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

    public function rewind()
    {
        $this->observers->rewind();
    }
}
