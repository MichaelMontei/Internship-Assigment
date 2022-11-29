<?php
/**
 * DateWithEquals
 *
 * @package Ai
 */

namespace Ai\Filter;

/**
 * DateWithEquals
 *
 * @package Ai
 */
class DateWithEquals extends \Ai\Filter\Date
{

    /**
     * Constructor
     *
     * @access public
     * @param string $id
     * @param string $label
     * @param \Ai\Filter\Interfaces\Applier $applier
     * @param string $format
     * @param bool $autoTimeComparison
     */
    public function __construct($id, $label, ApplierDateWithEquals $applier, $format = \M\Time\Date::SHORT, $autoTimeComparison = TRUE)
    {
        // Set the Applier description
        $applier->setDescription(t('@subject is @value'), array('EQ', '*'));

        // Construct
        parent::__construct($id, $label, $applier, $format, $autoTimeComparison);
    }

    /**
     * Get flag: is complete?
     *
     * @return boolean
     * @see \Ai\Filter\Interfaces\Filter::isComplete()
     * @access public
     */
    public function isComplete()
    {
        // Get filter values:
        $values = $this->getStepValues();

        // We expect 2 values; the comparison and the date. Make sure this is
        // the case, and if not:
        if (count($values) != 2) {
            // Return FALSE
            return FALSE;
        }

        // The first value must be the comparison. If that is not the case:
        if (!in_array($values[0], array(\M\Db\Operator::EQ, \M\Db\Operator::LT, \M\Db\Operator::GT))) {
            // Return FALSE
            return FALSE;
        }

        // The second value MUST be a date. If that is not the case:
        if (!(is_object($values[1]) && $values[1] instanceof \M\Time\Date)) {
            // Then, return FALSE
            return FALSE;
        }

        // Return TRUE, if still here
        return TRUE;
    }


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
            \M\Db\Operator::EQ => t('Is'),
            \M\Db\Operator::LT => t('Voor'),
            \M\Db\Operator::GT => t('Na')
        ));

        // Return the field:
        return $control;
    }

}