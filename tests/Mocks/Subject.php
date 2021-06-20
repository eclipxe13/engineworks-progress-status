<?php
namespace EngineWorks\ProgressStatus\Tests\Mocks;

use EngineWorks\ProgressStatus\AbstractSplSubject;

class Subject extends AbstractSplSubject
{
    public $foo = '';

    public function exposeObservers()
    {
        return parent::getObservers();
    }
}
