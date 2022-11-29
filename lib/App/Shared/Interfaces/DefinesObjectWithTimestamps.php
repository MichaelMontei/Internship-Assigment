<?php namespace App\Shared\Interfaces;

use M\DataObject\Interfaces\ObjectInterface;
use M\Time\Date;

/**
 * Interface DefinesObjectWithTimestamps
 *
 * @package App\Shared\Interfaces
 */
interface DefinesObjectWithTimestamps extends ObjectInterface
{
    /**
     * @return Date
     */
    public function getCreatedAt();

    /**
     * @param Date|null $date
     * @return DefinesObjectWithTimestamps
     */
    public function setCreatedAt(Date $date = null);

    /**
     * @return Date
     */
    public function getUpdatedAt();

    /**
     * @param Date|null $date
     * @return DefinesObjectWithTimestamps
     */
    public function setUpdatedAt(Date $date = null);
}
