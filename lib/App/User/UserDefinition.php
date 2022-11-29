<?php
/**
 * UserDefinition
 * 
 * @author pevara
 * @package Main
 * @subpackage User
 */

namespace App\User;

/**
 * Class UserDefinition
 * @package App\User
 */
class UserDefinition extends \User\Model\UserDefinition
{
	/* -- PRIVATE/PROTECTED -- */
	
	/**
	 * Get Definition Array
	 * 
	 * @access protected
	 * @return array
	 */
	protected function _getDefinition() {
		return [
			'table'   => [
				'name'   => 'users',
				'prefix' => 'user'
			],
			'columns' => [
				'id'						=> 'int auto+',

                // Login related
				'email'						=> 'varchar(255)',
				'password'					=> 'varchar(32)',
				'token'						=> 'varchar(255)',

                // Personal data of the user and the company they represent
                'firstName'                 => 'varchar(255) encrypted',
                'surname'                   => 'varchar(255) encrypted',
				'company'					=> 'varchar(255)',

                // UI + ACL related
                'locale'					=> 'varchar(2)',
                'roleId'					=> 'int(11)',
				'active'					=> 'tinyint(1)',

                // Timestamps
                'dateCreated'				=> 'datetime',
                'dateLastLogin'				=> 'datetime null',
                'dateLastVisit'				=> 'datetime null',
                'datePreviousVisit'			=> 'datetime null',
			],
			'indexes' => [
				'primary_key'	=> 'PRIMARY id',
				'email'			=> 'UNIQUE email',
				'active'		=> 'INDEX active',
			]
		];
	}

}