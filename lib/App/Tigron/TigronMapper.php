<?php

namespace App\Tigron;

use App\Shared\DataObject\MapperWithTimestamps;
use App\Shared\Interfaces\DefinesSoftDeletionMapper;
use App\Shared\Interfaces\DefinesObjectWithTimestamps;
use App\Shared\Traits\MapperWithSoftDeletes;

class TigronMapper extends MapperWithTimestamps implements DefinesSoftDeletionMapper
{
    use MapperWithSoftDeletes;


    /* -- PUBLIC -- */
}