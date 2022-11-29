<?php
/**
 * Main
 *
 * @package Admin
 * @package App
 */

namespace Front\Controller;

use M\Locale\Category;
use M\Locale\Locale;
use M\Locale\Strings;
use User\View\Mail;

/**
 * Main
 *
 * @package Admin
 * @package App
 */
class Main extends \M\Controller\Controller
{

    /* -- PUBLIC -- */

    /**
     * Main constructor.
     */
    public function __construct()
    {
//        if (TEST_AUTHENTICATION == true) {
//            if (
//                !isset($_SERVER['PHP_AUTH_USER'])
//                or $_SERVER['PHP_AUTH_USER'] != 'logimarket'
//                or $_SERVER['PHP_AUTH_PW'] != 't4kBZckq!twJwW9J'
//            ) {
//                header('WWW-Authenticate: Basic realm="Login"');
//                header('HTTP/1.0 401 Unauthorized');
//                echo 'Not authorized';
//                exit;
//            }
//        }

        Strings::getInstance()->setLocaleOfUntranslatedMessages(Locale::getCategory(Category::LANG));
    }

    /**
     * Is authenticated?
     *
     * @return bool
     */
    protected function _isAuthenticated()
    {
        return \User\Authentication::getInstance()->isAuthenticated();
    }

    /**
     * Get wrap
     *
     * @param string $pageTitle
     * @param string $pageDescription
     * @return \M\View\View
     */
    protected function _getWrap($pageTitle, $pageDescription)
    {
        return \M\App\Application::getConfig()->getWrap($pageTitle, $pageDescription);
    }

    /**
     * Get mail wrap
     *
     * @return \M\View\View
     */
    protected function _getMailWrap()
    {
        return \M\App\Application::getConfig()->getMailWrap();
    }

    /**
     * Handle Exceptions
     *
     * @access public
     * @param \Throwable $exception
     * @return void
     */
    public function handleError(\Throwable $exception)
    {
        // let the Error controller take care of things
        $controller = new Error();
        $controller->handleError($exception);
    }

    /**
     * 404 response
     *
     * @param string $message
     * @throws \M\Exception\ResourceNotFoundException
     */
    protected function _404(string $message = '')
    {
        throw new \M\Exception\ResourceNotFoundException($message);
    }

}

