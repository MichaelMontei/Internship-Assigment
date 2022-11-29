<?php
/**
 * Translations
 *
 * @package Ai
 */

namespace Ai\View\Cell;

/**
 * Translations
 *
 * @package Ai
 */
class Translations extends \Ai\View\Cell\Cell
{

    /* -- PRIVATE/PROTECTED -- */

    const STATUS_NOK = 'nok';
    const STATUS_PARTLY = 'partly';
    const STATUS_OK = 'ok';

    /**
     * Get Required Variables
     *
     * @return array
     * @see \M\View\View::_getRequired()
     * @access protected
     */
    protected function _getRequired()
    {
        return [];
    }

    /**
     * Preprocessing
     *
     * @return void
     * @throws \M\Exception\Exception
     * @access protected
     * @see \M\View\View::_preProcessing()
     */
    protected function _preProcessing()
    {
        // Parent preprocessing
        parent::_preProcessing();

        $icon = false;
        switch ($this->_getTranslationStatus()) {
            case self::STATUS_OK:
                $icon = 'check';
                break;
            case self::STATUS_NOK:
                $icon = 'question';
                break;
            case self::STATUS_PARTLY:
                $icon = 'circle-o';
                break;
        }
        $this->_setVariable('icon', $icon);
    }

    /**
     * @return string
     */
    protected function _getTranslationStatus()
    {
        $dataObject = $this->getDataObject();
        $columns = $dataObject->getNewMapper()->getDefinition()->getTable()->getColumns();

        $nlCounter = 0;
        $enCounter = 0;
        foreach ($columns as $column) {
            /* @var $column \M\DataObject\DefinitionColumn */
            if (!$column->isLocalized()) {
                continue;
            }

            $getter = $column->getGetter();
            $nlValue = $dataObject->$getter('nl');
            if (!$nlValue) {
                continue;
            }

            $nlCounter++;

            $enValue = $dataObject->$getter('en');
            if ($enValue) {
                $enCounter++;
            }
        }

        if ($enCounter == $nlCounter) {
            return self::STATUS_OK;
        }

        if ($enCounter == 0) {
            return self::STATUS_NOK;
        }

        return self::STATUS_PARTLY;
    }
}