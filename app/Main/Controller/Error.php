<?php
/**
 * Error
 *
 * @package Main
 * @package App
 */

namespace Main\Controller;

use ErrorException;
use M\App\Application;
use M\Controller\Controller;
use M\Debug\Console;
use M\Debug\Environment;
use M\Exception\ResourceNotFoundException;
use M\Server\Header;
use Main\View\Error\Error404;
use Throwable;

/**
 * Error
 *
 * @package Main
 * @package App
 */
class Error extends Controller
{

    /**
     * Handle error
     *
     * @param Throwable $exception
     * @throws Throwable
     */
    public function handleError(Throwable $exception)
    {
        // log the exception in the correct file
        if ($exception instanceof ResourceNotFoundException) {
            $consoleId = 'admin-404';
        } else if ($exception instanceof ErrorException) {
            $consoleId = 'admin-error';
        } else {
            $consoleId = 'admin-exception';
        }

        Console::getInstance($consoleId)
            ->write($exception->getMessage())
            ->write($exception->getTraceAsString());

        // if 'resource not found' and show dumps is disabled
        if (
            $exception instanceof ResourceNotFoundException
            && ! Environment::getConfig()->getShowDumps()
        ) {
            // throw a 404
            $this->_404();
        }
        // if pretty errors is enabled
        if (Environment::getConfig()->getShowDumps()) {
            // we let Whoops take care of it for us
            throw $exception;
        }

        // Send the appropriate header, when displaying this page,
        // so that this page is not considered a "success" page
        Header::sendHttpStatus(Header::STATUS_SERVER_ERROR);
        // we display the error
        (new \Main\View\Error\Error())
            ->addWrap(Application::getConfig()->getWrap('', ''))
            ->display()
            ;
    }


    /**
     * Handle "Error 404 - File Not Found"
     *
     * @access public
     * @return void
     */
    public function _404()
    {
        // Send the appropriate header, when displaying this page,
        // so that this page is not considered a "success" page
        Header::send404();
        (new Error404())
            ->addWrap(Application::getConfig()->getWrap('', ''))
            ->display()
            ;
        die();
    }
}

