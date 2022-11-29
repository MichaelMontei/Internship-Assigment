<?php namespace App\User;

use M\DataObject\Definition;

/**
 * Class UserEventDefinition
 * @package App\User
 */
class UserEventDefinition extends Definition
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
        return [
            'table' => [
                'name' => 'user_events',
                'prefix' => 'ue'
            ],
            'columns' => [
                'id' => 'int auto+',
                'userId' => 'int',
                'action' => 'varchar(16)',
                'objectMapper' => 'varchar(255)',
                'objectId' => 'int',
                'createdAt' => 'datetime null',
                'updatedAt' => 'datetime null',
            ],
            'indexes' => [
                'primary_key' => 'PRIMARY id',
                'user_object' => 'INDEX userId objectMapper objectId',
            ]
        ];
    }

}