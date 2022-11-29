<?php

namespace Ai\Form;

use Ai\Def\Form;
use Ai\Form\ControlDefs as Defs;
use Ai\Form\ControlDef as Def;
use M\DataObject\DefinitionColumn;
use M\Form\Control as Ctrl;
use M\Locale\Category;
use M\Locale\Locale;
use M\Locale\MessageCatalog;
use Samenaankoop\Helper\FormHelper;
use Samenaankoop\Translation\Translated;
use Samenaankoop\Translation\TranslatedMapper;
use Samenaankoop\Translation\TranslationHelper;

class TranslateObject extends \Ai\Def\Form
{

    /**
     * @var string
     */
    private $_def;

    /**
     * @var array
     */
    private $_localizedColumns = array();

    /**
     * Construct
     */
    public function __construct(Form $def)
    {
        // Set the title and introduction to the list:
        $this->_def = $def;

        $this->setTitle($def->getTitle() . ' (' . t('translations') . ')');

        // Set the buttons for the Form UI
        $this->setButtons(new \Ai\Def\Buttons([
            new \Ai\Def\Button('cancel', t('Cancel'), '', 'ai/grid/' . $def->getId(), TRUE, 'Are you sure?', 'Are you sure?')
        ]));
    }

    /**
     * @param array $columns
     * @return $this
     */
    public function setLocalizedColumns(array $columns)
    {
        $this->_localizedColumns = $columns;
        return $this;
    }

    /**
     * @param \Ai\Form\Form $form
     * @param array $vars
     * @return bool
     */
    public function getActionsPostProcessing(\Ai\Form\Form $form, array $vars)
    {
        $dataObject = $this->getDataObject();

        $localesToHandle = MessageCatalog::getStorage()->getInstalledLocales();
        if (($key = array_search(Locale::getCategory(Category::LANG), $localesToHandle)) !== false) {
            unset($localesToHandle[$key]);
        }

        foreach ($this->_localizedColumns as $column) {
            /* @var $column DefinitionColumn */
            $setter = $column->getSetter();

            foreach ($localesToHandle as $locale) {
                $dataObject->$setter($vars[$column->getId() . '-' . $locale], $locale);
            }
        }

        $dataObject->save();

        return parent::getActionsPostProcessing($form, $vars);
    }


    /**
     * Get Listing
     *
     * Will provide with the AI Listing Definition that goes with the Form Definition.
     * Some properties in the Listing may influence the behavior in the Form. For example,
     * when the form is completed, the user is redirected back to the Listing's URL by
     * default.
     *
     * NOTE:
     * By default, this method will load a Grid Definition with the same ID. You can
     * overwrite this in your subclass though!
     *
     * @access public
     * @return \Ai\Def\Listing
     */
    public function getListing()
    {
        return \Ai\Controller\Loader::getGrid($this->_def->getId());
    }

}
