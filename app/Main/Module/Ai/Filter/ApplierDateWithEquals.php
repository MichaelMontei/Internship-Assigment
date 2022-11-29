<?php
/**
 * Applier
 *
 * @package Ai
 */

namespace Ai\Filter;

use Ai\Filter\Applier;
use M\DataObject\FilterWhere;
use M\Db\Operator;

/**
 * Applier
 *
 * @package Ai
 */
class ApplierDateWithEquals extends Applier
{

    /**
     * Apply the filter
     *
     * @access public
     * @param \M\DataObject\Interfaces\Mapper $mapper
     * @param \Ai\Filter\Filter $filter
     * @return \Ai\Filter\Interfaces\Applier
     * @see \Ai\Filter\Interfaces\Applier::apply()
     */
    public function apply(\M\DataObject\Interfaces\Mapper $mapper, \Ai\Filter\Filter $filter)
    {
        // If the filter is not complete
        if (!$filter->isComplete()) {
            // Then we throw an exception. We cannot apply a filter if its values are
            // not known:
            throw new \M\Exception\RuntimeErrorException(sprintf(
                'Cannot apply Filter [%s]! The filter is not complete.',
                $filter->getId()
            ));
        }

        if ($filter->getStepValue(0) != Operator::EQ) {
            return parent::apply($mapper, $filter);
        }

        $date = clone $filter->getStepValue(1);
        /* @var $date \M\Time\Date */
        $date->setTime(0, 0, 0);
        $mapper->addFilter(new FilterWhere($this->_getTarget(), $date, Operator::GTEQ));

        $date = clone $filter->getStepValue(1);
        /* @var $date \M\Time\Date */
        $date->setTime(23, 59, 59);
        $mapper->addFilter(new FilterWhere($this->_getTarget(), $date, Operator::LTEQ));

        return $this;
    }

}