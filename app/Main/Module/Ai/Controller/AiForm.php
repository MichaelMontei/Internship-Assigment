<?php
/**
 * AiAction
 *
 * @package App
 * @subpackage Ai
 */

namespace Ai\Controller;

use M\Locale\Category;
use M\Locale\Locale;
use M\Locale\MessageCatalog;
use Ai\Form\TranslateObject;
use Ai\Form\ControlDef;
use Ai\Form\ControlDefs;

/**
 * AiAction
 *
 * @package App
 * @subpackage Ai
 */
class AiForm extends \Main\Controller\MainAuthenticated
{

    use \Ai\Controller\Traits\Form;

    /* -- PRIVATE/PROTECTED -- */

    /**
     * Get View
     *
     * @param \Ai\View\Interfaces\Form $view
     * @return \Ai\View\Interfaces\Form
     * @see \Ai\Controller\Form
     * @access protected
     */
    protected function _getView(\Ai\View\Interfaces\Def\Form $view)
    {
        return $view->addWrap(\M\App\Application::getConfig()->getWrap());
    }

    /**
     * Edit Data Object
     *
     * @access public
     * @param string $defId
     * @param string $hashId
     * @return void
     */
    public function translations($defId, $hashId = NULL)
    {
        // Set Default View Classes for Form Controls
        \M\Form\Control\Control::setDefaultViewClass('\\Ai\\View\\FormControl');
        \M\Form\Control\Control::setDefaultDecoratorViewClass('\\Ai\\View\\FormControlDecorator');

        // Get the Form Definition
        $formDef = \Ai\Controller\Loader::getForm($defId);
        $def = new TranslateObject($formDef);

        // Get the Data Object, and provide it to the Form Definition:
        $dataObject = $this->_getDataObject($formDef, $hashId);
        $formDef->setDataObject($dataObject);
        $def->setDataObject($dataObject);

        $controls = new ControlDefs();
        $localizedColumns = array();

        $localesToHandle = MessageCatalog::getStorage()->getInstalledLocales();
        $widthPerControl = floor(12 / count($localesToHandle));
        if (($key = array_search(Locale::getCategory(Category::LANG), $localesToHandle)) !== false) {
            unset($localesToHandle[$key]);
        }

        foreach ($formDef->getControlDefs() as $controlDef) {
            /* @var $controlDef \Ai\Form\ControlDef */
            $columnId = $controlDef->getControl()->getId();
            $column = $def->getMapper()->getDefinition()->getTable()->getColumnById($columnId);

            if (!$column) {
                continue;
            }

            if (!$column->isLocalized()) {
                continue;
            }

            $localizedColumns[] = $column;

            $controlDef->getControl()->getViewDecorator()->setWidthDecorator($widthPerControl);
            $controls->append($controlDef);

            foreach ($localesToHandle as $localeToHandle) {
                $controlDefLocale = clone $controlDef;

                $getter = $column->getGetter();

                $control = $controlDefLocale->getControl();
                $decorator = $control->getViewDecorator();
                $decorator->setTitle(strtoupper($localeToHandle));
                $decorator->setWidthDecorator($widthPerControl);
                $control->setId($control->getId() . '-' . $localeToHandle);
                $control->setDefaultValue($dataObject->$getter($localeToHandle));
                $controls->append($controlDefLocale);
            }

            $controlDef->getControl()->setReadOnly(true);
        }

        $def->setControlDefs($controls);
        $def->setLocalizedColumns($localizedColumns);

        // We run the form. If the result is SUCCESS, we redirect now:
        $form = $def->getForm();
        if ($form->run()) {
            $form->redirect(TRUE);
        }

        // Get the View, and ask the app's AI Controller to decorate it:
        $view = $this->_getView($def->getView());

        // We expect an instance of \Ai\View\Interfaces\Form to be returned by that.
        // If that is not the case, we throw an exception:
        if (!(is_object($view) && $view instanceof \Ai\View\Interfaces\Def\Form)) {
            throw new \M\Exception\RuntimeErrorException(sprintf(
                'An instance of %s is expected to be returned by %s::%s()',
                '\Ai\View\Interfaces\Def\Form',
                get_class($this),
                '_getView()'
            ));
        }

        // Output the view:
        $view->display();
    }
}