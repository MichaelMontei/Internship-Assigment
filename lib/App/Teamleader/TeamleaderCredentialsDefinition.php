<?php

namespace App\Teamleader;

use M\DataObject\Definition;

class TeamleaderCredentialsDefinition extends Definition
{
    /* -- PRIVATE/PROTECTED -- */

    protected function _getDefinition(): array
    {
        return [
            'table'   => [
                'name'   => 'teamleader_credentials',
                'prefix' => 'teamleader_credentials'
            ],
            'columns' => [
                'id'					    => 'int auto+',
                'value'                     => 'text',
//                'token type'                => 'text',
//                'access token'              => 'text',
//                'refresh token'             => 'text',


                // Timestamps
                'createdAt'     => 'datetime null',
                'updatedAt'     => 'datetime null',
                'dateDeleted'   => 'datetime null',
//                'expiresIn'     => 'datetime null',

            ],
            'indexes' => [
                'primary_key'	=> 'PRIMARY id',


            ]
        ];
    }
}

