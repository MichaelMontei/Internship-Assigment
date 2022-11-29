<?php

namespace App\Teamleader;

use M\DataObject\Definition;

class TeamleaderCompanyDefinition extends Definition
{
    /* -- PRIVATE/PROTECTED -- */

    protected function _getDefinition(): array
    {
        return [
            'table'   => [
                'name'   => 'company',
                'prefix' => 'company'
            ],
            'columns' => [
                'id'						=> 'int auto+',
                'teamLeaderId'              => 'varchar(255)',
                'name'                      => 'varchar(255)',
                'address'                   => 'varchar(255)',
                'vatNumber'                => 'varchar(255)',
                'paymentTerm'              => 'varchar(255)',
                'poNumber'                 => 'tinyint(1)',
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
