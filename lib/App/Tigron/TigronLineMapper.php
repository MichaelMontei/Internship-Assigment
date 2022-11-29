<?php

namespace App\Tigron;

use App\Shared\DataObject\MapperWithTimestamps;
use App\Shared\Interfaces\DefinesSoftDeletionMapper;
use App\Shared\Traits\MapperWithSoftDeletes;

class TigronLineMapper extends MapperWithTimestamps implements DefinesSoftDeletionMapper
{
    use MapperWithSoftDeletes;


    /* -- PUBLIC -- */
}