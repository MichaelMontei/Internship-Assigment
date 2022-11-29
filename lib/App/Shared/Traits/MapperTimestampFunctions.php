<?php namespace App\Shared\Traits;

use M\DataObject\FilterOrder;
use M\DataObject\Interfaces\ObjectInterface;
use M\DataObject\Mapper;
use M\Exception\RuntimeErrorException;
use M\Time\Date;
use App\Shared\Interfaces\DefinesObjectWithTimestamps;

/**
 * Trait MapperTimestampFunctions
 *
 * @package App\Shared\Traits
 */
trait MapperTimestampFunctions
{
    /* -- FILTERS -- */

    /**
     * Sort by date created:
     *
     * @param string $order
     * @return $this
     */
    public function addFilterSortByCreatedAt($order = 'ASC')
    {
        return $this->addFilter(new FilterOrder('createdAt', $order));
    }

    /**
     * Sort by date updated:
     *
     * @param string $order
     * @return $this
     */
    public function addFilterSortByUpdatedAt($order = 'ASC')
    {
        return $this->addFilter(new FilterOrder('updatedAt', $order));
    }


    /* -- CRUD -- */

    /**
     * @param ObjectInterface $object
     * @return bool
     * @throws RuntimeErrorException
     */
    public function insert(ObjectInterface $object)
    {
        if ( ! $object instanceof DefinesObjectWithTimestamps) {
            throw new RuntimeErrorException(
                'Object [' . get_class($object) . '] does not implement DefinesObjectWithTimestamps, ' .
                'while its mapper is configured as such.'
            );
        }
        $object->setCreatedAt(new Date());
        return parent::insert($object);
    }

    /**
     * @param ObjectInterface $object
     * @return bool
     * @throws RuntimeErrorException
     */
    public function update(ObjectInterface $object)
    {
        if ( ! $object instanceof DefinesObjectWithTimestamps) {
            throw new RuntimeErrorException(
                'Object [' . get_class($object) . '] does not implement DefinesObjectWithTimestamps, ' .
                'while its mapper is configured as such.'
            );
        }
        $object->setUpdatedAt(new Date());
        return parent::update($object);
    }
}
