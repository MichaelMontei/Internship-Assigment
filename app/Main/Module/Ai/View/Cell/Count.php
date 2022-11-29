<?php
/**
 * Count
 */

namespace Ai\View\Cell;

/**
 * Count
 */
abstract class Count extends \Ai\View\Cell\Cell
{

    /* -- PUBLIC -- */

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
    }

    /* -- PROTECTED -- */

    /**
     * Preprocessing
     */
    protected function _preProcessing()
    {
        parent::_preProcessing();
        $this->_setVariable('count', $this->_getMapper()->getCount());
    }

    /**
     * Get required
     *
     * @return array
     */
    protected function _getRequired()
    {
        return [];
    }

    /* -- ABSTRACT -- */

    /**
     * Get mapper
     *
     * @return \M\DataObject\Mapper
     */
    abstract protected function _getMapper();

}