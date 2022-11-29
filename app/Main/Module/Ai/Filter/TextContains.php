<?php
/**
 * TextContains
 *
 * @package Ai
 */

namespace Ai\Filter;

use Ai\Filter\Text;

/**
 * TextContains
 *
 * @package Ai
 */
class TextContains extends Text
{

    /* -- PRIVATE/PROTECTED -- */

    /**
     * Get default Control, for step 1
     *
     * @access protected
     * @return \M\Form\Control\Options
     */
    protected function _getDefaultControlStep1()
    {
        // Construct the field:
        $control = new \M\Form\Control\Options('step1');

        // Set the options for the field:
        $control->setOptions(array(
            \M\Db\Operator::CONTAINS => t('contains')
        ));

        // Return the field:
        return $control;
    }

}