<?php
declare(strict_types=1);

namespace EngineWorks\ProgressStatus;

interface ProgressInterface extends \SplSubject
{
    /**
     * Return the current progress status
     * @return Status
     */
    public function getStatus();

    /**
     * Increase the progress
     *
     * @param string|null $message
     * @param int|float|null $increase
     * @return void
     */
    public function increase($message = null, $increase = 1);

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
        $message = null,
        $value = null,
        $total = null,
        $startTime = null,
        $current = null
    );

    /**
     * Compare both states and return if the status should change
     *
     * @param Status $current
     * @param Status $newStatus
     * @return bool
     */
    public function shouldNotifyChange(Status $current, Status $newStatus);
}
