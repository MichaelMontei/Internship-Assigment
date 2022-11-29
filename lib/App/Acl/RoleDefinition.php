<?php
/**
 * RoleDefinition
 *
 * @author Wim
 */

namespace App\Acl;

use M\DataObject\Definition;

/**
 * RoleDefinition
 *
 * Used to specify a role
 */
class RoleDefinition extends Definition
{

    /* -- PRIVATE/PROTECTED -- */

    /**
     * Get Definition Array
     *
     * @access protected
     * @return array
     */
    protected function _getDefinition()
    {
        return array(
            'table' => array(
                'name' => 'acl_roles',
                'prefix' => 'aro'
            ),
            'columns' => array(
                'id' => 'int(11) auto+',
                'title' => 'varchar(255)',
                'realm' => 'varchar(255)',
                'createdAt' => 'datetime null',
                'updatedAt' => 'datetime null',
            ),
            'indexes' => array(
                'primary_key' => 'PRIMARY id',
                'realm' => 'INDEX realm',
            )
        );
    }
}