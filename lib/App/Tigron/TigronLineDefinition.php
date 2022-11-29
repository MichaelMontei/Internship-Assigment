<?php

namespace App\Tigron;

use M\DataObject\Definition;

class TigronLineDefinition extends Definition
{
    /* -- PRIVATE/PROTECTED -- */

    protected function _getDefinition(): array
    {
        return [
            'table'   => [
                'name'   => 'tigroninvoiceline',
                'prefix' => 'tigroninvoiceline'
            ],
            'columns' => [
                'id'				=> 'int auto+',
                'clientId'          => 'int',
                'invoiceNumber'		=> 'int',
                'name'              => 'varchar(255)',
                'statusCode'        => 'tinyint(1)',

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
