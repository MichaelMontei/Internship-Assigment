<?php
/**
 * RegisterActivated
 */

namespace Front\Module\User\View;

use User\Model\Interfaces\User;

/**
 * RegisterActivated
 */
class RegisterActivated extends \M\View\View {
	
	/**
	 * Set user
	 * 
	 * @param User $user
	 * @return $this
	 */
	public function setUser(User $user) {
		$this->_setVariable('user', $user);
		return $this;
	}
	
	/**
	 * Get required
	 * 
	 * @return array
	 */
	protected function _getRequired() {
		return ['user'];
	}
}