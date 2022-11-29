<?php namespace Ai\Controller;

use App\Acl\Gatekeeper;

/**
 * AiGrid
 *
 * @package App
 * @subpackage Ai
 */
class AiGrid extends \Main\Controller\MainAuthenticated
{

    use \Ai\Controller\Traits\Grid;

    /* -- PUBLIC -- */

    /**
     * List
     *
     * @access public
     * @param string $defId
     * @return void
     */
    public function index($defId)
    {
        // Get the list definition:
        $grid = \Ai\Controller\Loader::getGrid($defId);

        // Check access
        if (!Gatekeeper::hasAccessTo('ai:' . $defId)) {
            redirect(href());
        }

        // Clear the selection of instances that might have been made earlier.
        // Everytime the list view is shown, we assume that the selection is
        // no longer active...
        $grid->getSelection()->reset();

        // Construct the list view, and display:
        $grid
            ->getView()
            ->addWrap(\M\App\Application::getConfig()->getWrap())
            ->display();
    }
}