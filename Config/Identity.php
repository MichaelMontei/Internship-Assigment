<?php
/**
 * Identity
 *
 * @author Tim
 */

namespace Config;

use M\App\Config;

/**
 * Identity
 */
class Identity extends Config
{

    /* -- CONSTRUCTOR -- */

    /**
     * Constructor
     *
     * @access public
     */
    public function __construct()
    {
        parent::__construct(array(
            'Name' => 'Your project',
            'Address' => array(
                array(
                    'StreetName' => '',
                    'StreetNumber' => '',
                    'City' => '',
                    'PostalCode' => '',
                    'CountryISO' => '',
                    'Latitude' => '',
                    'Longitude' => '',
                    'Type' => ''
                ),
            ),
            'Emails' => array(
                'info' => 'info@yourproject.be',
                'from' => 'no-reply@yourproject.be',
            ),
            'Phones' => array(
                'Tel' => '',
            ),
            'Vat' => ''
        ));
    }
}