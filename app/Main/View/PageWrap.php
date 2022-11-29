<?php namespace Main\View;

// PHTML PLUGINS
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'src/main/function.php';

/**
 * Class PageWrap
 * @package Main\View
 */
class PageWrap extends \M\View\View
{
    /* -- PUBLIC -- */

    /**
     * Set page title
     *
     * @param string $pageTitle
     * @return $this
     */
    public function setPageTitle($pageTitle)
    {
        $this->_setVariable('pageTitle', \M\Util\Text::getSnippet($pageTitle, 60));
        return $this;
    }

    /**
     * Set page description
     *
     * @param string $pageDescription
     * @return $this
     */
    public function setPageDescription($pageDescription)
    {
        $this->_setVariable('pageDescription', \M\Util\Text::getSnippet($pageDescription, 200));
        return $this;
    }

    /* -- PROTECTED -- */

    /**
     * Preprocessing
     */
    protected function _preProcessing()
    {
        parent::_preProcessing();

        // Messages
        $messenger = new \M\Session\Messenger();
        $this->_setVariable('messages', $messenger->getMessages());
        $messenger->clear();
    }

    /* -- REQUIRED -- */

    /**
     * Get required variables
     *
     * @return array
     */
    protected function _getRequired()
    {
        return ['pageTitle', 'pageDescription'];
    }
}