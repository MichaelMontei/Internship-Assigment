<?php namespace App\Acl;

use M\Exception\RuntimeErrorException;
use M\Object\StaticClass;
use M\Util\ArrayHelper;
use App\Env\App;
use App\User\User;
use User\Authentication;

/**
 * Gatekeeper
 *
 * This ACL class is based on what Inflow offered. We merely simplified things
 * a bit. In practice, we might expand upon this at a later stage.
 *
 * @author Tim
 */
class Gatekeeper extends StaticClass
{
    /* -- CONSTANTS -- */

    // These constants correspond to the primary keys of the acl_roles table,
    // which is sufficient for now
    const ROLE_ADMIN_ID = 1;
    const ROLE_USER_ID = 2;

    /* -- PUBLIC -- */

    /**
     * Does the currently logged in user have access to the given resource?
     *
     * @param string $resource
     * @return bool
     */
    public static function hasAccessTo(string $resource): bool
    {
        // We need to be authenticated
        if (!Authentication::getInstance()->isAuthenticated()) {
            return false;
        }

        // Fetch the role of the currently logged in user
        $role = static::getActiveRole();

        // Fetch their rulebook
        $rules = ArrayHelper::getElement($role->getId(), static::getRulesByRole());

        // Feth the requested value. If missing, default to FALSE
        return ArrayHelper::getElement($resource, $rules, false);
    }

    /**
     * Is the user allowed to create the given resource?
     *
     * @param string $resource
     * @return bool
     */
    public static function canCreate(string $resource): bool
    {
        // If we're in non-CRUD mode, stop here
        if (!App::getInstance()->isCrudAllowed()) {
            return false;
        }

        // For now, ignore the resource. Create access is globalized
        return static::hasAccessTo('crud:create');
    }

    /**
     * Is the user allowed to edit the given resource?
     *
     * @param string $resource
     * @return bool
     */
    public static function canEdit(string $resource): bool
    {
        // If we're in non-CRUD mode, stop here
        if (!App::getInstance()->isCrudAllowed()) {
            return false;
        }

        // For now, ignore the resource. Edit access is globalized
        return static::hasAccessTo('crud:edit');
    }

    /**
     * Is the user allowed to delete the given resource?
     *
     * @param string $resource
     * @return bool
     */
    public static function canDelete(string $resource): bool
    {
        // If we're in non-CRUD mode, stop here
        if (!App::getInstance()->isCrudAllowed()) {
            return false;
        }

        // For now, ignore the resource. Delete access is globalized
        return static::hasAccessTo('crud:delete');
    }

    /**
     * Get the active role we have to ACL check
     *
     * @return Role
     */
    public static function getActiveRole(): Role
    {
        // Get the role object of this user
        $user = Authentication::getInstance()->getAuthUser();

        if (!$user) {
            throw new \RuntimeException(sprintf('No authenticated user found!'));
        }

        $role = (new RoleMapper())->getById($user->getRoleId());

        /* @var $user User */
        /* @var $role Role */
        if (!$role) {
            throw new RuntimeErrorException(sprintf(
                    'Unknown ACL role for user %s', $user->getId())
            );
        }

        return $role;
    }

    /**
     * Get rules by role
     *
     * For now, our ACL in this project is really, really simple. As such, we
     * will simply maintain an array of rules here.
     *
     * @return array
     *      Key   = role ID
     *      Value = array with allowed paths
     */
    public static function getRulesByRole()
    {
        return [
            static::ROLE_ADMIN_ID => [
                // CRUD settings, global
                'crud:create' => true,
                'crud:edit' => true,
                'crud:delete' => true,

                // Admin as a menu item
                'admin' => true,

                // Individual AI definitions the user has access to. Missing = no access
                'ai:user' => true,

                // Translation files
                'locales' => true,
            ],
            static::ROLE_USER_ID => [
                // CRUD settings, global
                'crud:create' => true,
                'crud:edit' => true,
                'crud:delete' => true,

                // Admin as a menu item
                'admin' => false,

                // Individual AI definitions the user has access to. Missing = no access

                // Translation files
                'locales' => false,
            ],
        ];
    }
}
