<?php namespace Front\Controller;

use App\User\User;
use M\Locale\Category;
use M\Locale\Locale;
use M\Locale\Strings;
use M\Server\Request;
use M\Session\Ns;
use M\Uri\Uri;
use User\Authentication;

/**
 * Main
 *
 * @package Main
 * @package App
 */
abstract class MainAuthenticated extends Main
{

    /**
     * Construct
     */
    public function __construct()
    {
        if (!$this->_isAuthenticated()) {
            redirect(href('user/login'));
        }

        Strings::getInstance()->setLocaleOfUntranslatedMessages(Locale::getCategory(Category::LANG));
    }

    /**
     * Get the authenticated user
     *
     * @return User
     */
    public function getAuthUser(): User
    {
        if (!$this->_isAuthenticated()) {
            throw new \RuntimeException(sprintf(
                'Cannot provide auth user; noone is authenticated!'
            ));
        }

        return Authentication::getInstance()->getAuthUser();
    }
}

