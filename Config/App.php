<?php
/**
 * App
 *
 * @author Tim
 */

namespace Config;

use M\App\Config;

/**
 * App
 */
class App extends Config
{

    /* -- CONSTRUCTOR -- */

    /**
     * Constructor
     *
     * @access public
     */
    public function __construct(array $parentValues = NULL)
    {
        $values = [
            'encryption' => [
                // Random string
                'key' => 'zci7EaFPrQTi6ZbWcDbmjjRKuKbZex'
            ],
            'bcrypt' => [
                // Random string
                'salt' => 'QQ8gWzhuasg9VK69Np9MtJ6yaTH6GG8TwpziiL9k',
                'workfactor' => 12
            ],
            'mail'  => [
                'mailtrap'  => [
                    'active'    => defined('MAILTRAP_ACTIVE') ? MAILTRAP_ACTIVE : false,
                    'username'  => defined('MAILTRAP_USERNAME') ? MAILTRAP_USERNAME : '',
                    'password'  => defined('MAILTRAP_PASSWORD') ? MAILTRAP_PASSWORD : '',
                ],
            ],
        ];

        if ($parentValues !== null) {
            $values = array_merge($values, $parentValues);
        }

        parent::__construct($values);
    }
}