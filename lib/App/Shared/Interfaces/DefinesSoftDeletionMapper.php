<?php namespace App\Shared\Interfaces;

use M\DataObject\Interfaces\Mapper;

/**
 * Interface DefinesSoftDeletionMapper
 *
 * @package App\Shared\Interfaces
 */
interface DefinesSoftDeletionMapper extends Mapper
{
    /**
     * Add filter: deleted?
     *
     * @param bool $flag
     * @return DefinesSoftDeletionMapper|Mapper
     */
    public function addFilterDeleted($flag = true);

    /**
     * "Un soft delete" the given object
     *
     * @param CanBeSoftDeleted $object
     * @return bool|mixed
     */
    public function unSoftDelete(CanBeSoftDeleted $object);

    /**
     * Soft Delete the given object
     *
     * @param CanBeSoftDeleted $object
     * @return bool|mixed
     */
    public function softDelete(CanBeSoftDeleted $object);
}
