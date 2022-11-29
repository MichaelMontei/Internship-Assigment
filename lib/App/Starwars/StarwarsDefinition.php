<?php

namespace App\Starwars;

use M\DataObject\Definition;

class StarwarsDefinition extends Definition
{
    /* -- PRIVATE/PROTECTED -- */

    protected function _getDefinition(): array
    {
        return [
            'table'   => [
                'name'   => 'starwars',
                'prefix' => 'starwars'
            ],
            'columns' => [
                'id'						=> 'int auto+',
                'name'                      => 'varchar(255)',
                'height'                    => 'int',
                'gender'                    => 'varchar(255)',

                // Timestamps
                'createdAt'     => 'datetime null',
                'updatedAt'     => 'datetime null',
                'dateDeleted'   => 'datetime null',
            ],
            'indexes' => [
                'primary_key'	=> 'PRIMARY id',


            ]
        ];
    }
}

