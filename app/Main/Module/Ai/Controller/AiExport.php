<?php
/**
 * AiExport
 *
 * @package App
 * @subpackage Ai
 */

namespace Ai\Controller;

/**
 * AiExport
 *
 * @package App
 * @subpackage Ai
 */
class AiExport extends \Main\Controller\MainAuthenticated
{

    use \Ai\Controller\Traits\Export;

    /* -- PUBLIC -- */

    /**
     * Step 1: Render the screen that will start importing (kickoff)
     *
     * @access public
     * @param string $defId
     * @return void
     */
    public function kickoff($defId)
    {
        // Get the definition:
        $def = \Ai\Controller\Loader::getExport($defId);

        // We construct the view:
        $view = new \Ai\View\ExportKickoff($def);

        // Wrap the view, and display
        $view
            ->addWrap(\M\App\Application::getConfig()->getWrap())
            ->display();
    }

}