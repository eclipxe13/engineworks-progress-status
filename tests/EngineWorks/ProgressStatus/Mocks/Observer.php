<?php
namespace Tests\EngineWorks\ProgressStatus\Mocks;

use EngineWorks\ProgressStatus\ProgressInterface;

class Observer implements \SplObserver
{
    /** @var \SplSubject */
    public $subject = null;

    /** @var string[] */
    public $updates = [];

    public function update(\SplSubject $subject)
    {
        $this->subject = $subject;
        if ($subject instanceof ProgressInterface) {
            $status = $subject->getStatus();
            $this->updates[] = $status->getMessage() . ' [' . $status->getValue() . '/' . $status->getTotal() . ']';
        }
    }
}
