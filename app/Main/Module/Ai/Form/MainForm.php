<?php namespace Ai\Form;

use Ai\Def\Form;
use App\Location\City;
use App\Location\CityMapper;
use App\User\User;
use M\Cache\CachePhp;
use M\Form\Control\Address;
use M\Form\Control\Control;
use M\Form\Control\Options;
use User\Authentication;

/**
 * Class User
 *
 * @package Main\Module\Ai\Form
 */
abstract class MainForm extends Form
{
    /* -- PROPERTIES -- */

    /**
     * Currently authenticated user
     *
     * @var User
     */
    private $authUser;

    /* -- PRIVATE/PROTECTED -- */

    /**
     * @return User
     */
    protected function getAuthUser()
    {
        if (is_null($this->authUser)) {
            $this->authUser = Authentication::getInstance()->getAuthUser();
        }
        return $this->authUser;
    }
}