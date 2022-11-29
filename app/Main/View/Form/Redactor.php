<?php

namespace Main\View\Form;

/**
 * Class Redactor
 * @package Main\View\Form
 */
class Redactor extends \Ai\View\FormControl
{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();

        $this->setRedactorOptions([
            'buttons' => ['formatting', 'html', 'bold', 'italic', 'unorderedlist', 'orderedlist', 'link', 'horizontalrule', 'html'],
            'formattingAdd' => [
                [
                    'tag' => 'p',
                    'title' => 'Info Box',
                    'class' => 'info-box'
                ]
            ]
        ]);
    }

    /**
     * set redactor options
     *
     * @param array $json
     * @return $this
     */
    public function setRedactorOptions(array $json)
    {
        $this->_setVariable('redactorOptions', $json);
        return $this;
    }


    /**
     * Get template filename
     * @return string
     */
    protected function _getTemplateFilename()
    {
        return "form/control/Redactor";
    }

}