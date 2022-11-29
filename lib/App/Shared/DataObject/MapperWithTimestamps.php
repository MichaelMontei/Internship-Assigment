<?php namespace App\Shared\DataObject;

use M\DataObject\Mapper;
use App\Shared\Interfaces\DefinesMapperWithTimestamps;
use App\Shared\Traits\MapperTimestampFunctions;

/**
 * Class MapperWithTimestamps
 *
 * @package App\Shared\DataObject
 */
abstract class MapperWithTimestamps extends Mapper implements DefinesMapperWithTimestamps
{
    use MapperTimestampFunctions;
}
