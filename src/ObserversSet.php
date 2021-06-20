<?php
namespace EngineWorks\ProgressStatus;

class ObserversSet implements \Countable, \Iterator
{
    /** @var \SplObjectStorage */
    private $observers;

    public function __construct()
    {
        $this->observers = new \SplObjectStorage();
    }

    public function attach(\SplObserver $observer)
    {
        $this->observers->attach($observer);
    }

    public function detach(\SplObserver $observer)
    {
        $this->observers->detach($observer);
    }

    public function count()
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

    public function valid()
    {
        return $this->observers->valid();
    }

    public function rewind()
    {
        $this->observers->rewind();
    }
}
