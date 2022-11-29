<?php namespace App\Starwars;

use App\Shared\DataObject\MapperWithTimestamps;
use App\Shared\Interfaces\DefinesSoftDeletionMapper;
use App\Shared\Traits\MapperWithSoftDeletes;

class StarwarsMapper extends MapperWithTimestamps implements DefinesSoftDeletionMapper
{
    use MapperWithSoftDeletes;


    /* -- PUBLIC -- */
}