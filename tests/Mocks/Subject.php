<?php
declare(strict_types=1);

namespace EngineWorks\ProgressStatus\Tests\Mocks;

use EngineWorks\ProgressStatus\AbstractSplSubject;
use EngineWorks\ProgressStatus\ObserversSet;

class Subject extends AbstractSplSubject
{
    /**
     * @var string
     */
    public $foo = '';

    public function exposeObservers(): ObserversSet
    {
        return parent::getObservers();
    }
}
