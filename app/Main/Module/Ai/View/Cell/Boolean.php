<?php
/**
 * Boolean cell view
 *
 * @package Ai
 */

namespace Ai\View\Cell;

/**
 * Boolean cell view
 */
class Boolean extends \Ai\View\Cell\Cell
{

    /* -- CONSTRUCTORS -- */

    /**
     * Construct
     *
     * @param bool $flag
     *        The boolean we want to display as a string
     * @return \Ai\View\Cell\Boolean
     */
    public function __construct($flag)
    {
        // Assign the variable
        $this->_setVariable('value', (bool)$flag);

        // Costruct the parent
        parent::__construct();
    }

    /* -- PRIVATE/PROTECTED -- */

    /**
     * Get Required Variables
     *
     * @return array
     * @see \M\View\View::_getRequired()
     * @access protected
     */
    protected function _getRequired()
    {
        return [];
    }
}