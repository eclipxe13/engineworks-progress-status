<?php

declare(strict_types=1);

namespace EngineWorks\ProgressStatus\Tests\Mocks;

use EngineWorks\ProgressStatus\ObserversSet;
use EngineWorks\ProgressStatus\SplSubjectWithObserversTrait;
use SplSubject;

class Subject implements SplSubject
{
    use SplSubjectWithObserversTrait;

    /** @var string */
    public $foo = '';

    public function __construct()
    {
        $this->constructSplSubjectWithObservers();
    }

    public function exposeObservers(): ObserversSet
    {
        return $this->getObservers();
    }
}
