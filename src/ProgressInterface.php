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
     * @param string|null $message
     * @param int|float|null $increase
     * @return void
     */
    public function increase(string $message = null, $increase = 1): void;

    /**
     * Update the status with this values
     *
     * @param string|null $message
     * @param int|float|null $value
     * @param int|float|null $total
     * @param int|null $startTime
     * @param int|null $current
     * @return void
     */
    public function update(
        string $message = null,
        $value = null,
        $total = null,
        int $startTime = null,
        int $current = null
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
