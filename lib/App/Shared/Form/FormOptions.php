<?php namespace App\Shared\Form;

use M\DataObject\Interfaces\Mapper;
use M\Exception\InvalidArgumentException;
use App\Shared\Interfaces\DefinesSoftDeletionMapper;

/**
 * Class FormOptions
 *
 * @package App\Shared\Form
 */
class FormOptions
{
    /* -- PUBLIC -- */

    /**
     * Will build you an array using the provided mapper's records using getAll();
     *
     * Options can be provided to further customize the resulting array
     *
     * Note: Should the mapper implement the interface DefinesSoftDeletionMapper,
     * then the deleted(false) filter will be applied inside this function!
     *
     * @param Mapper $mapper
     * @param string $emptyString
     * @param string $key
     * @param string $value
     * @param bool $useGetters
     * @return array
     * @throws InvalidArgumentException
     */
    public static function withMapper(Mapper $mapper, $emptyString = '--', $key = 'id', $value = 'title', $useGetters = false)
    {
        $out = [];
        if ($emptyString) {
            $out[''] = $emptyString;
        }
        $table = $mapper->getDefinition()->getTable();
        if ($mapper instanceof DefinesSoftDeletionMapper) {
            $mapper->addFilterDeleted(false);
        }
        foreach ($mapper->getAll() as $object) {
            if ($useGetters) {
                $out[$object->$key()] = $object->$value();
                continue;
            }
            $keyColumn = $table->getColumnById($key);
            if ( ! $keyColumn) {
                throw new InvalidArgumentException(
                    'Unknown key property [' . $key . '] provided to FormOptions::withMapper()'
                );
            }
            $valueColumn = $table->getColumnById($value);
            if ( ! $valueColumn) {
                throw new InvalidArgumentException(
                    'Unknown value property [' . $value . '] provided to FormOptions::withMapper()'
                );
            }
            $keyGetter      = $keyColumn->getGetter();
            $valueGetter    = $valueColumn->getGetter();
            $out[$object->$keyGetter()] = $object->$valueGetter();
        }
        return $out;
    }

    /**
     * Make sure the input - whatever it is - is a clean array of integer ids
     *
     * @param mixed $ids
     * @return array
     */
    public static function getCleanIds($ids): array
    {
        $ids = is_array($ids) ? $ids : [];
        foreach ($ids as $key => $id) {
            $ids[$key] = (int) $id;
        }

        return $ids;
    }
}
