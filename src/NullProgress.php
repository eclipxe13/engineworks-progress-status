<?php
declare(strict_types=1);

namespace EngineWorks\ProgressStatus;

use SplObserver;

/**
 * NullProgress is a null object implementation of ProgressInterface.
 */
class NullProgress implements ProgressInterface
{
    /** @var Status */
    private $status;

    public function __construct(Status $status = null)
    {
        $this->status = $status ? : Status::make();
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function increase($message = null, $increase = 1)
    {
    }

    /**
     * @inheritdoc
     * @codeCoverageIgnore null implementation
     */
    public function update(
        $message = null,
        $value = null,
        $total = null,
        $startTime = null,
        $current = null
    ) {
    }

    public function shouldNotifyChange(Status $current, Status $newStatus)
    {
        return false;
    }

    /**
     * @inheritdoc
     * @codeCoverageIgnore null implementation
     */
    public function attach(SplObserver $observer)
    {
    }

    /**
     * @inheritdoc
     * @codeCoverageIgnore null implementation
     */
    public function detach(SplObserver $observer)
    {
    }

    /**
     * @inheritdoc
     * @codeCoverageIgnore null implementation
     */
    public function notify()
    {
    }
}
