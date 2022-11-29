<?php
/**
 * AiAction
 *
 * @package App
 * @subpackage Ai
 */

namespace Ai\Controller;

/**
 * AiAction
 *
 * @package App
 * @subpackage Ai
 */
class AiAction extends \Main\Controller\MainAuthenticated
{

    use \Ai\Controller\Traits\Action;

    /**
     * Cell Action: TOGGLE
     *
     * @access public
     * @param \Ai\View\Cell\Toggle $cell
     * @return void
     * @see \Ai\Controller\Action::cell()
     */
    protected function _cellToggle(\Ai\View\Cell\Toggle $cell)
    {
        // Get the Data Object:
        $object = $cell->getDataObject();

        // We swith to the opposite state of the toggle field:
        $columnId = $cell->getToggleColumnId();
        $object->$columnId = $cell->getNewState();

        // Construct the Response:
        $response = new \Ai\Response\Toggle();

        $result = $object->save();

        // Send the response
        $response
            ->setToggleState($cell->getNewState())
            ->setToggleStateLabel($cell->getNewStateLabel())
            ->setOutcomeFlag($result)
            ->send();
    }

}