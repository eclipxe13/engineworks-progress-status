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

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function increase(string $message = null, $increase = 1): void
    {
    }

    /**
     * @inheritdoc
     * @codeCoverageIgnore null implementation
     */
    public function update(
        string $message = null,
        $value = null,
        $total = null,
        int $startTime = null,
        int $current = null
    ): void {
    }

    public function shouldNotifyChange(Status $current, Status $newStatus): bool
    {
        return false;
    }

    /**
     * @inheritdoc
     * @codeCoverageIgnore null implementation
     */
    public function attach(SplObserver $observer): void
    {
    }

    /**
     * @inheritdoc
     * @codeCoverageIgnore null implementation
     */
    public function detach(SplObserver $observer): void
    {
    }

    /**
     * @inheritdoc
     * @codeCoverageIgnore null implementation
     */
    public function notify(): void
    {
    }
}
