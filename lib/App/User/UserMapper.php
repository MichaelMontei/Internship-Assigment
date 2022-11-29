<?php namespace App\User;

use M\DataObject\FilterOrder;
use M\DataObject\FilterWhere;
use M\DataObject\Interfaces\ObjectInterface;
use M\Db\Operator;
use M\Util\StringHelper;

/**
 * Class UserMapper
 * @package App\User
 */
class UserMapper extends \User\Model\UserMapper
{
    /* -- PUBLIC -- */

    /**
     * Add filter: inactive only
     *
     * @return $this
     */
    public function addFilterInactiveOnly()
    {
        $this->addFilter(new FilterWhere('active', 0));
        return $this;
    }

    /**
     * Add filter: active only
     *
     * @return $this
     */
    public function addFilterActiveOnly()
    {
        $this->addFilter(new FilterWhere('active', 1));
        return $this;
    }

    /**
     * Add filter: token
     *
     * @param string $token
     * @return $this
     */
    public function addFilterToken($token)
    {
        $this->addFilter(new FilterWhere('token', $token));
        return $this;
    }

    /**
     * Add filter: email
     *
     * @param string $email
     * @return $this
     */
    public function addFilterEmail($email)
    {
        $this->addFilter(new FilterWhere('email', $email));
        return $this;
    }

    /**
     * Add filter: default sorting
     *
     * @return $this
     */
    public function filterDefaultSorting()
    {
        $this->addFilter(new FilterOrder('surname', 'asc'));
        return $this;
    }

    /**
     * Save
     *
     * @param ObjectInterface $object
     * @return bool
     */
    public function save(ObjectInterface $object)
    {
        /* @var $object \App\User\User */
        if (!$object->getToken()) {
            $object->setToken(StringHelper::getUniqueToken());
        }

        return parent::save($object);
    }
}