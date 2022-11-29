<?php namespace App\Shared\Interfaces;

use M\Time\Date;

/**
 * Interface CanBeSoftDeleted
 *
 * @package App\Shared\Interfaces
 */
interface CanBeSoftDeleted
{
    /* -- PUBLIC -- */

    /**
     * Get the date on which it is "deleted"
     *
     * @return null|Date
     */
    public function getDateDeleted();

    /**
     * Set the date on which it is "deleted"
     *
     * @param null|Date $date
     * @return mixed
     */
    public function setDateDeleted(Date $date = null);
}
