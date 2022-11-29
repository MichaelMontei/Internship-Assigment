<?php namespace Front\Module\Locale\Form;

use M\Form\Control\Options;
use M\Form\Controls;
use M\Form\Form;
use M\Form\View\Mode;
use M\Fs\Local\File;
use M\Locale\Charset;
use M\Locale\Locale;
use M\Locale\MessageCatalog;
use M\Locale\PO;
use M\Server\Header;
use M\Time\Date;

/**
 * Class Export
 * @package Main\Module\Locale\Form
 */
class Export extends Form
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
            $this->_getControlLocales()
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
     * @param array $variables
     * @return bool|void
     */
    protected function _actions(array $variables)
    {
        $locale = $variables['locale'];
        $catalog = MessageCatalog::getInstance($locale);
        $storage = $catalog->getTranslations();
        $po = new PO();
        $po->setCharset(Charset::UTF8);
        $po->setNumberOfPluralForms($storage->getNumberOfPluralForms());
        $po->setPluralFormulaInPhp($storage->getPluralFormula());
        $po->setHeader(PO::LANGUAGE, $locale);
        $po->setHeader(PO::PROJECT_ID_VERSION, name());
        $po->setPotCreationDate(new Date());

        foreach ($storage->getMessages() as $msg) {
            /* @var $msg \M\Locale\Message */
            $po->addMessage($msg);
        }

        $filename = $locale . '-' . (new Date())->toString('ddMMYYYY-HHmm') . '.po';
        Header::sendDownloadFromString($po->toString(), new File($filename));
    }
}
