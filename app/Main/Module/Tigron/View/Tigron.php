<?php

namespace Main\Module\Tigron\View;


use M\DataObject\ResultSet;
use M\Exception\InvalidArgumentException;
use M\View\Resources;
use M\View\View;

class Tigron extends View
{
    /**
     * Preprocessing
     *
     * @return void
     * @throws InvalidArgumentException
     * @see View::_preProcessing()
     * @access protected
     */
    protected function _preProcessing()
    {
        // Get the View Resources (Singleton)
        $resources = \M\View\Resources::getInstance();

        /* @var $resources Resources */
        $resources->addSourcePath('js/invoice.js', 'javascript');
    }

    protected function _getRequired(): array
    {
        return [
            'tigron',
        ];
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setTest(ResultSet $_teamLeaderId): self
    {
        $this->_setVariable('tigron', $_teamLeaderId);
        return $this;
    }
}
