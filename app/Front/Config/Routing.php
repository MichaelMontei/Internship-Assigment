<?php
/**
 * Routing
 *
 * @package Admin
 * @package App
 */

namespace Front\Config;

/**
 * Routing
 *
 * @package Admin
 * @package App
 */
class Routing extends \M\App\Config
{

    /* -- CONSTRUCTOR -- */

    /**
     * Constructor
     *
     * @access public
     */
    public function __construct()
    {
        parent::__construct([
            'thumbnail(:any)' => 'thumbnail/index$1',
            '(:any)' => 'home/index',
        ]);
    }

}