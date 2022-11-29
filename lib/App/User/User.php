<?php namespace App\User;

use M\Mail\MailHelper;

class User extends UserDataObject implements \User\Model\Interfaces\User
{
    /* -- PUBLIC -- */
		
	/**
	 * Get full name
	 * 
	 * @return string
	 */
	public function getFullName()
    {
		return trim($this->getFirstName() . ' ' . $this->getSurname());
	}
	
	/**
	 * Get recipient string
	 * 
	 * @return string
	 */
	public function getRecipientString()
    {
		return MailHelper::getRecipientStringFormat(
			$this->getFullName(),
			$this->getEmail()
		);
	}

    /**
     * Get active for display {t('Ja') or t('Nee')}
     *
     * @return string
     */
    public function getActiveForDisplay()
    {
        return $this->getActive() ? t('Ja') : t('Nee');
	}
}