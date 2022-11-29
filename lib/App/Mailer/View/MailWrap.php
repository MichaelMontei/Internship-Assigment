<?php namespace App\Mailer\View;

class MailWrap extends Mail
{
	/* -- PRIVATE/PROTECTED -- */

	/**
	 * Preprocessing
	 */
	protected function _preProcessing()
    {
		parent::_preProcessing();
	}
	
	/**
	 * Get required variables
	 *
	 * @return array
	 */
	protected function _getRequired()
    {
		return [];
	}

    /**
     * Get Template Filepath
     *
     * @param string $filename
     * @return string
     */
	protected function _getTemplateFilepath($filename = null)
    {
		return 'src/shared/template/mailer/MailWrap.phtml';
	}
}
