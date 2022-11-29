<?php namespace Front\Module\Locale\View;

use M\Form\Form;
use M\View\View;

/**
 * Class Locale
 *
 * @package Main\Module\Locale\View
 */
abstract class Locale extends View
{
    /* -- PUBLIC -- */

    /**
     * Set reaction
     *
     * @param Form $form
     * @return Locale $view
     */
    public function setForm(Form $form)
    {
        $this->_setVariable('form', $form);
        return $this;
    }

    /**
     * Get required
     *
     * @return array
     */
    protected function _getRequired()
    {
        return ['form'];
    }
}
