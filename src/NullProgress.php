<?php

declare(strict_types=1);

namespace EngineWorks\ProgressStatus;

use SplObserver;

/**
 * NullProgress is a null object implementation of ProgressInterface.
 *
 * @infection-ignore-all
 * @codeCoverageIgnore Null implementation
 */
class NullProgress implements ProgressInterface
{
    /** @var Status */
    private $status;

    public function __construct(?Status $status = null)
    {
        $this->status = $status ?: Status::make();
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function increase(string $message = '', $increase = 1): void
    {
    }

    /**
     * @inheritdoc
     */
    public function update(
        string $message = '',
        ?int $value = null,
        ?int $total = null,
        ?int $startTime = null,
        ?int $current = null
    ): void {
    }

    public function shouldNotifyChange(Status $current, Status $newStatus): bool
    {
        return false;
    }

    public function attach(SplObserver $observer): void
    {
    }

    public function detach(SplObserver $observer): void
    {
    }

    public function notify(): void
    {
    }
}
