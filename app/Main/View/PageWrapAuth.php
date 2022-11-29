<?php namespace Main\View;

use M\Session\Messenger;
use M\View\View;

/**
 * Class PageWrapAuth
 * @package Main\View
 */
class PageWrapAuth extends View
{

    /* -- PROPERTIES -- */

    /**
     * @var string
     */
    private $_activePath;

    /* -- PUBLIC -- */

    /**
     * Set active path
     *
     * @param string $activePath
     * @return $this
     */
    public function setActivePath(string $activePath)
    {
        $this->_activePath = $activePath;
        return $this;
    }

    /* -- PROTECTED -- */

    /**
     * Preprocessing
     */
    protected function _preProcessing()
    {
        parent::_preProcessing();
        $this->_setVariable('menu', new MainMenu());
        $this->_setVariable('activePath', $this->_activePath);
        $this->_setVariable('messages', Messenger::getMessages());
    }

    /**
     * Get required
     *
     * @return array
     */
    protected function _getRequired()
    {
        return ['menu'];
    }
}