<?php namespace Front\View;

use App\User\User;
use M\Exception\ResourceNotFoundException;
use M\View\View;
use User\Authentication;

abstract class ViewWithUser extends View
{
    /* -- PROPERTIES -- */

    /**
     * User
     *
     * @var User
     */
    private $user;

    /* -- PUBLIC SCOPE -- */

    /**
     * Set user
     *
     * Can be set manually, but will be fetched from Auth by default.
     *
     * @param User $user
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get the set user
     *
     * @return User
     */
    public function getUser(): User
    {
        if ( ! $this->user) {
            $user = Authentication::getInstance()->getAuthUser();
            if ( ! $user) {
                throw new ResourceNotFoundException(sprintf(
                    'Cannot provide User from auth; no User set!'
                ));
            }
        }

        return $this->user;
    }

    /* -- PRIVATE/PROTECTED -- */

    /**
     * Preprocessing
     *
     * @return void
     */
    protected function _preProcessing()
    {
        $this->_setVariable('user', $this->user);
    }
}
