<?php namespace Front\Module\User\View;

use App\Mailer\View\Mail;
use User\Model\Interfaces\User;

/**
 * RegisterActivationMail
 */
class RegisterActivationMail extends Mail
{
    /**
     * Set user
     *
     * @param User $user
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->_setVariable('title', t('Activate your account'));
        $this->_setVariable('user', $user);
        return $this;
    }

    /* -- REQUIRED -- */

    /**
     * Get required
     *
     * @return array
     */
    protected function _getRequired()
    {
        return ['user'];
    }
}