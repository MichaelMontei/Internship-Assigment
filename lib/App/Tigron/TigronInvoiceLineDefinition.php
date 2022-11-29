<?php

namespace App\Tigron;

use M\DataObject\Definition;

class TigronInvoiceLineDefinition extends Definition
{
    /* -- PRIVATE/PROTECTED -- */

    protected function _getDefinition(): array
    {
        return [
            'table'   => [
                'name'   => 'tigroninvoice',
                'prefix' => 'tigroninvoice'
            ],
            'columns' => [
                'id'				=> 'int auto+',
                'TeamLeaderId'		=> 'varchar(255)',
                'domain'            => 'varchar(255)',
                'lineText'          => 'varchar(255)',

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
