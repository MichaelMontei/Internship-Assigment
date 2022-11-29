<?php

namespace App\Testing;

use App\Shared\DataObject\MapperWithTimestamps;
use App\Shared\Interfaces\DefinesSoftDeletionMapper;
use App\Shared\Traits\MapperWithSoftDeletes;

class TestingMapper extends MapperWithTimestamps implements DefinesSoftDeletionMapper{
    use MapperWithSoftDeletes;
}