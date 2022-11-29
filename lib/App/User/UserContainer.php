<?php namespace App\User;

use App\Acl\Role;
use App\Acl\RoleMapper;

/**
 * User
 * 
 * @author M
 * @package User
 */
class UserContainer
{
	/* -- PROPERTIES -- */
	
	/**
	 * User
	 * 
	 * @var User
	 */
	private $_user;

	/** -- PUBLIC -- */

    /**
     * Construct
     *
     * @param User $user
     */
	public function __construct(User $user)
    {
		$this->_user = $user;
	}
	
	/**
	 * Get user
	 * 
	 * @return User
	 */
	public function getUser()
    {
		return $this->_user;
	}

	/**
	 * Get role
	 * 
	 * @return Role
     */
	public function getRole()
    {
		/* @var $role Role */
		$role = (new RoleMapper())->getById($this->getUser()->getRoleId());
		return $role;
	}

	/**
	 * Save!
	 * 
	 * @return boolean
	 */
	public function save()
    {
		$user = $this->_user;
		
		// Save the user
		if ( ! $user->save()) {
			return false;
		}
		
		return true;
	}
}
