<?php
/**
 * Ai
 *
 * @package Ai
 */

namespace Ai\Controller;

use Throwable;

/**
 * Ai
 *
 * @package Ai
 */
class Ai extends \Main\Controller\MainAuthenticated
{

    /* -- M/CONTROLLER -- */

    /**
     * Handle Error
     *
     * @param Throwable $e
     * @return void
     * @see \M\Controller\Interfaces\Controller
     * @access public
     */
    public function handleError(Throwable $e)
    {
        // let the Error controller take care of things
        $controller = new \Main\Controller\Error();
        $controller->handleError($e);
    }
}