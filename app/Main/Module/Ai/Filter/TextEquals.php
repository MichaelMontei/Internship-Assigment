<?php
/**
 * TextEquals
 *
 * @package Ai
 */

namespace Ai\Filter;

use Ai\Filter\Text;

/**
 * TextEquals
 *
 * @package Ai
 */
class TextEquals extends Text
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
            \M\Db\Operator::EQ => t('is')
        ));

        // Return the field:
        return $control;
    }

}