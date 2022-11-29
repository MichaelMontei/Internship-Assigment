<?php namespace Locale\Controller;

use Main\Controller\MainAuthenticated;
use Locale\Form\Export as ExportForm;
use Locale\View\Export as ExportView;
use Locale\Form\Import as ImportForm;
use Locale\View\Import as ImportView;

/**
 * Class Locale
 *
 * @package Main\Module\Locale\Controller
 */
class Locale extends MainAuthenticated
{
    /* -- PUBLIC -- */

    /**
     * Export
     *
     * @return void
     */
    public function export()
    {
        $form = (new ExportForm());
        $form->setAttribute('data-no-loading');

        if (!$form->run()) {
            (new ExportView())
                ->setForm($form)
                ->addWrap($this->_getWrap('', ''))
                ->display();
        }
    }

    /**
     * Import
     *
     * @return void
     */
    public function import()
    {
        $form = (new ImportForm());
        $form->setAttribute('data-no-loading');

        $form->setRedirectUriWithPath('locale/import');

        if (!$form->run()) {
            (new ImportView())
                ->setForm($form)
                ->addWrap($this->_getWrap('', ''))
                ->display();
        }
    }
}
