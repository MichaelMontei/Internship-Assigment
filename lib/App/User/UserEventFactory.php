<?php namespace App\User;

use M\DataObject\Mapper;
use User\Authentication;

/**
 * UserEventFactory
 *
 * Used to easily create user events
 *
 * @author Tim
 */
class UserEventFactory
{
    /**
     * Log a user event
     *
     * @param string $action
     * @param Mapper $mapper
     * @param int $id
     * @return UserEvent
     */
    public static function create(string $action, Mapper $mapper, int $id): UserEvent
    {
        /* @var $user User */
        $user = Authentication::getInstance()->getAuthUser();
        if (!$user) {
            throw new \RuntimeException(sprintf(
                'Cannot log UserEvent; no logged in user found'
            ));
        }

        $obj = new UserEvent();
        $obj->setUserId($user->getId());
        $obj->setAction($action);
        $obj->setObjectMapper(get_class($mapper));
        $obj->setObjectId($id);
        (new UserEventMapper())->insert($obj);

        return $obj;
    }
}