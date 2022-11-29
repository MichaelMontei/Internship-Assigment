<?php

namespace App\Tigron;

use M\DataObject\Definition;

class TigronDefinition extends Definition
{
    /* -- PRIVATE/PROTECTED -- */

    protected function _getDefinition(): array
    {
        return [
            'table'   => [
                'name'   => 'tigron',
                'prefix' => 'tigron'
            ],
            'columns' => [
                'id'						    => 'int auto+',
                'username'                      => 'varchar(255)',
                'customer'                      => 'varchar(255)',
                'productDescription'            => 'varchar(255)',
                'price'                         => 'float(11)',
                'ignore'                        => 'tinyint(1)',
                'teamleaderInvoiceNumber'       => 'varchar(255)',

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
