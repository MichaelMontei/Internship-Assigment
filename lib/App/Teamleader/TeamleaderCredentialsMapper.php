<?php namespace App\Teamleader;

use App\Shared\DataObject\MapperWithTimestamps;
use App\Shared\Interfaces\DefinesSoftDeletionMapper;
use App\Shared\Interfaces\DefinesObjectWithTimestamps;
use App\Shared\Traits\MapperWithSoftDeletes;

class TeamleaderCredentialsMapper extends MapperWithTimestamps implements DefinesSoftDeletionMapper
{
    use MapperWithSoftDeletes;


    /* -- PUBLIC -- */
}
