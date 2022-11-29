<?php namespace App\Shared\Interfaces;

use M\DataObject\Interfaces\Mapper;
use M\DataObject\Interfaces\ObjectInterface;

/**
 * Interface DefinesMapperWithTimestamps
 *
 * @package App\Shared\Interfaces
 */
interface DefinesMapperWithTimestamps extends Mapper
{
    /**
     * @param ObjectInterface $object
     * @return DefinesMapperWithTimestamps
     */
    public function insert(ObjectInterface $object);

    /**
     * @param ObjectInterface $object
     * @return DefinesMapperWithTimestamps
     */
    public function update(ObjectInterface $object);
}
