<?php namespace App\Teamleader;

use App\Shared\DataObject\MapperWithTimestamps;
use App\Shared\Interfaces\DefinesSoftDeletionMapper;
use App\Shared\Traits\MapperWithSoftDeletes;

class TeamleaderCompanyMapper extends MapperWithTimestamps implements DefinesSoftDeletionMapper
{
    use MapperWithSoftDeletes;


    /* -- PUBLIC -- */
}

