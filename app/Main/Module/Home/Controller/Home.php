<?php namespace Home\Controller;

use Main\Controller\Main;

/**
 * Class Home
 * @package Main\Module\Home\Controller
 */
class Home extends Main
{
    /**
     * Home
     *
     * @access public
     * @return void
     */
    public function index()
    {
        (new \Home\View\Home())
            ->addWrap(
                $this->_getWrap(t('Welcome to @name', ['@name' => name()]), '')
            )
            ->display();
    }
}