<?php namespace App\Shared\Traits;

use M\DataObject\FilterWhere;
use M\DataObject\Interfaces\ObjectInterface;
use M\DataObject\Mapper;
use M\Db\Operator;
use M\Exception\InvalidArgumentException;
use M\Time\Date;
use App\Shared\Interfaces\CanBeSoftDeleted;

/**
 * Trait MapperWithSoftDeletes
 *
 * @package App\Traits
 */
trait MapperWithSoftDeletes
{
    /* -- FILTERS -- */

    /**
     * Add filter: deleted?
     *
     * @param bool $flag
     * @return MapperWithSoftDeletes|Mapper
     */
    public function addFilterDeleted($flag = true)
    {
        return $this->addFilter(new FilterWhere(
            'dateDeleted',
            null,
            $flag ? Operator::ISN : Operator::IS
        ));
    }


    /* -- PUBLIC -- */

    /**
     * "Un soft delete" the given object
     *
     * @param CanBeSoftDeleted $object
     * @return bool|mixed
     */
    public function unSoftDelete(CanBeSoftDeleted $object)
    {
        // If it's already "not-deleted" no use in moving on
        if ( ! $object->getDateDeleted()) {
            return true;
        }
        $object->setDateDeleted(null);
        /* @var $object ObjectInterface */
        return $this->save($object);
    }

    /**
     * Soft Delete the given object
     *
     * @param CanBeSoftDeleted $object
     * @return bool|mixed
     */
    public function softDelete(CanBeSoftDeleted $object)
    {
        // If it has already been deleted, no use in "deleting it again"
        if ($object->getDateDeleted()) {
            return true;
        }
        $object->setDateDeleted(new Date());
        /* @var $object ObjectInterface */
        return $this->save($object);
    }


    /* -- CRUD -- */

    /**
     * Overwriting the original mapper's delete() function, to soft delete these objects instead!
     * Since we're overwriting, we need to check on the object's interface inside the function rather
     * than apply it as parameter.
     *
     * @param ObjectInterface $object
     * @return bool|mixed
     * @throws InvalidArgumentException
     */
    public function delete(ObjectInterface $object)
    {
        if ($object instanceof CanBeSoftDeleted) {
            return $this->softDelete($object);
        }
        $class      = get_class($object);
        $partials   = explode('\\', $class);
        $className  = array_pop($partials);
        throw new InvalidArgumentException(
            '[' . $className . '] is an object that uses soft deletes, ' .
            'for which it must implement the CanBeSoftDeleted interface!'
        );
    }
}
