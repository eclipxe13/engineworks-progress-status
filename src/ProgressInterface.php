<?php

declare(strict_types=1);

namespace EngineWorks\ProgressStatus;

use SplSubject;

interface ProgressInterface extends SplSubject
{
    /**
     * Return the current progress status
     * @return Status
     */
    public function getStatus(): Status;

    /**
     * Increase the progress
     *
     * @param string $message
     * @param int $increase
     * @return void
     */
    public function increase(string $message = '', int $increase = 1): void;

    /**
     * Update the status with this values
     *
     * @param string $message
     * @param int|null $value
     * @param int|null $total
     * @param int|null $startTime
     * @param int|null $current
     * @return void
     */
    public function update(
        string $message = '',
        int $value = null,
        int $total = null,
        int $startTime = null,
        int $current = null,
    ): void;

    /**
     * Compare both states and return if the status should change
     *
     * @param Status $current
     * @param Status $newStatus
     * @return bool
     */
    public function shouldNotifyChange(Status $current, Status $newStatus): bool;
}
