<?php

namespace Locale\Form;

use M\Form\Control\Options;
use M\Form\Control\Upload;
use M\Form\Control\Upload\FileHandler;
use M\Form\Control\Upload\StorageLocal;
use M\Form\Controls;
use M\Form\Form;
use M\Form\View\Mode;
use M\Fs\Local\Directory;
use M\Locale\Locale;
use M\Locale\MessageCatalog;
use M\Locale\PO;

/**
 * Class Import
 *
 * @package Main\Module\Locale\Form
 */
class Import extends Form
{
    /* -- PRIVATE/PROTECTED -- */

    /**
     * Get controls
     *
     * @return Controls
     */
    protected function _getControls()
    {
        return new Controls([
            $this->_getControlLocales(),
            $this->_getControlFile()
        ]);
    }

    /**
     * Get Control: "Locales"
     *
     * @return Options $control
     */
    protected function _getControlLocales()
    {
        $control = new Options('locale', true, false);
        $control->getView()->setMode(Mode::SELECT);

        $control->addOption('', '--');
        foreach (MessageCatalog::getStorage()->getInstalledLocales() as $locale) {
            $control->addOption($locale, Locale::getLanguageDisplayName($locale));
        }

        return $control;
    }

    /**
     * Get Control: "File"
     *
     * @return Upload $control
     */
    protected function _getControlFile()
    {
        return new Upload(
            'file',
            new FileHandler('file', ['po'], '2MB'),
            new StorageLocal(new Directory('files/po')),
            true
        );
    }

    /**
     * Actions
     *
     * @param array $variables
     * @return boolean
     */
    protected function _actions(array $variables)
    {
        $locale = $variables['locale'];
        $fileStorage = $variables['file'];

        /*@var $storage \M\Form\Control\Upload\StorageLocal*/
        $file = array_shift($fileStorage->store());

        if (!$file || !$file->exists()) {
            return false;
        }

        $catalog = MessageCatalog::getInstance($locale);
        $storage = $catalog->getTranslations();

        $storage->addMessagesWithPo(
            PO::constructWithFile($file)
        );

        return $file->delete();
    }
}
