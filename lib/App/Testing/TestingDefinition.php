<?php

namespace App\Testing;

use M\DataObject\Definition;

class TestingDefinition extends Definition
{
    /* -- PRIVATE/PROTECTED -- */

    protected function _getDefinition(): array
    {
        return [
            'table'   => [
                'name'   => 'testing',
                'prefix' => 'testing'
            ],
            'columns' => [
                'id'						=> 'int auto+',
                'name'                      => 'varchar(255)',
                'address'                   => 'varchar(255)',
                'vatNumber'                => 'varchar(255)',
                'paymentTerm'              => 'varchar(255)',
                'poNumber'                 => 'varchar(255)',
                'email'                     => 'varchar(255)',
                'country'                   => 'varchar(255)',

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

