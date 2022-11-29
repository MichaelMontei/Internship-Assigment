<?php namespace App\Shared\Filter;

/**
 * Class FilterRadius
 *
 * @package App\Shared\Filter
 */
class FilterRadius
{
    /* -- PROPERTIES -- */

    /**
     * @var string
     */
    private $latitude;

    /**
     * @var string
     */
    private $longitude;

    /**
     * @var int
     */
    private $sizeInKm;

    /**
     * @var string
     */
    private $order;


    /* -- CONSTRUCTOR -- */

    /**
     * FilterRadius constructor.
     * @param string $latitude
     * @param string $longitude
     * @param int $sizeInKm
     * @param string $order
     */
    public function __construct($latitude, $longitude, $sizeInKm, $order = 'ASC')
    {
        $this->latitude     = $latitude;
        $this->longitude    = $longitude;
        $this->sizeInKm     = $sizeInKm;
    }


    /* -- PUBLIC -- */

    /**
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @return int
     */
    public function getSizeInKm()
    {
        return $this->sizeInKm;
    }

    /**
     * @return string
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Returns the distance calculation string, to be used in queries
     * with distance radius filtering.
     * You can pass on alternative lat & long properties, to enable the
     * use of joined tables
     *
     * @param string $latProperty
     * @param string $longProperty
     * @param string $latPlaceholder
     * @param string $longPlaceholder
     * @return string
     */
    public static function getDistanceCalculationString(
        $latProperty = '{latitude}',
        $longProperty = '{longitude}',
        $latPlaceholder = ':latitude',
        $longPlaceholder = ':longitude'
    ) {
        $out = '6371*ACos(';                                // '6371*ACos(';
        $out .= 'Cos(RADIANS(' . $latProperty . '))*';      // 'Cos(RADIANS({latitude}))*';
        $out .= 'Cos(RADIANS(' . $latPlaceholder . '))*';   // 'Cos(RADIANS(:latitude))*';
        $out .= 'Cos(';                                     // 'Cos(';
        $out .= 'RADIANS(' . $longPlaceholder . ')-';       // 'RADIANS(:longitude)-';
        $out .= 'RADIANS(' . $longProperty . '))+';         // 'RADIANS({longitude}))+';
        $out .= 'Sin(RADIANS(' . $latProperty . ')';        // 'Sin(RADIANS({latitude})';
        $out .= ')*';                                       // ')*';
        $out .= 'Sin(RADIANS(' . $longPlaceholder . '))';   // 'Sin(RADIANS(:latitude))';
        $out .= ')';                                        // ')';

        return $out;
    }
}
