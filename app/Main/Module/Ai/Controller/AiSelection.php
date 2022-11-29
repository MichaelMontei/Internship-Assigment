<?php
/**
 * AiSelection
 *
 * @package Ai
 */

namespace Ai\Controller;

/**
 * AiSelection
 *
 * @package Ai
 */
class AiSelection extends \Main\Controller\MainAuthenticated
{

    use \Ai\Controller\Traits\Selection;

    /* -- PUBLIC -- */

    /**
     * Confirm Action
     *
     * @access public
     * @param string $defId
     * @param string $buttonId
     * @return void
     */
    public function confirmAction($defId, $buttonId)
    {
        // Construct the Grid
        $grid = \Ai\Controller\Loader::getGrid($defId);

        // Get the Action/Button Selected:
        $button = $grid->getButtonsSelection()->getById($buttonId);

        // If we cannot identify that button, we issue a 404 Error:
        if (!$button) {
            throw new \M\Exception\ResourceNotFoundException(sprintf(
                'Cannot identify selected Button, with Button ID [%s]!',
                $buttonId
            ));
        }

        // Construct the view:
        $view = new \Ai\View\ConfirmAction($grid, $button);

        // Add the wrapper, and display
        $view
            ->addWrap(new \Main\View\PageWrap())
            ->display();
    }

}