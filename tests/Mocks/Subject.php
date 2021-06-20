<?php
declare(strict_types=1);

namespace EngineWorks\ProgressStatus\Tests\Mocks;

use EngineWorks\ProgressStatus\AbstractSplSubject;

class Subject extends AbstractSplSubject
{
    /**
     * @var string
     */
    public $foo = '';

    public function exposeObservers(): \EngineWorks\ProgressStatus\ObserversSet
    {
        return parent::getObservers();
    }
}
