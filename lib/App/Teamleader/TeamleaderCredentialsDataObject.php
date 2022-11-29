<?php
/**
 * TeamleaderCredentialsDataObject
 * 
 * @author M
 * @package TeamleaderCredentials
 */

namespace App\Teamleader;

/**
 * TeamleaderCredentialsDataObject
 * 
 * @author M
 * @package TeamleaderCredentials
 */
abstract class TeamleaderCredentialsDataObject extends \M\DataObject\DataObject {
	/**
	 * Property "id"
	 * 
	 * @access private
	 * @var int
	 */
	private $_id;

	/**
	 * Property "value"
	 * 
	 * @access private
	 * @var string
	 */
	private $_value;

	/**
	 * Property "createdAt"
	 * 
	 * @access private
	 * @var \M\Time\Date
	 */
	private $_createdAt;

	/**
	 * Property "updatedAt"
	 * 
	 * @access private
	 * @var \M\Time\Date
	 */
	private $_updatedAt;

	/**
	 * Property "dateDeleted"
	 * 
	 * @access private
	 * @var \M\Time\Date
	 */
	private $_dateDeleted;

	/**
	 * Set Property "id"
	 * 
	 * @access public
	 * @param int $value
	 * @return \App\Teamleader\TeamleaderCredentialsDataObject
	 */
	public function setId($value) {
		$this->_id = $value; return $this;

	}
	
	/**
	 * Set Property "value"
	 * 
	 * @access public
	 * @param string $value
	 * @return \App\Teamleader\TeamleaderCredentialsDataObject
	 */
	public function setValue($value) {
		$this->_value = $value; return $this;

	}
	
	/**
	 * Set Property "createdAt"
	 * 
	 * @access public
	 * @param \M\Time\Date $value
	 * @return \App\Teamleader\TeamleaderCredentialsDataObject
	 */
	public function setCreatedAt(\M\Time\Date $value = NULL) {
		$this->_createdAt = $value; return $this;

	}
	
	/**
	 * Set Property "updatedAt"
	 * 
	 * @access public
	 * @param \M\Time\Date $value
	 * @return \App\Teamleader\TeamleaderCredentialsDataObject
	 */
	public function setUpdatedAt(\M\Time\Date $value = NULL) {
		$this->_updatedAt = $value; return $this;

	}
	
	/**
	 * Set Property "dateDeleted"
	 * 
	 * @access public
	 * @param \M\Time\Date $value
	 * @return \App\Teamleader\TeamleaderCredentialsDataObject
	 */
	public function setDateDeleted(\M\Time\Date $value = NULL) {
		$this->_dateDeleted = $value; return $this;

	}
	
	/**
	 * Get Property "id"
	 * 
	 * @access public
	 * @return int
	 */
	public function getId() {
		return $this->_id;
	}
	
	/**
	 * Get Property "value"
	 * 
	 * @access public
	 * @return string
	 */
	public function getValue() {
		return $this->_value;
	}
	
	/**
	 * Get Property "createdAt"
	 * 
	 * @access public
	 * @return \M\Time\Date
	 */
	public function getCreatedAt() {
		return $this->_createdAt;
	}
	
	/**
	 * Get Property "updatedAt"
	 * 
	 * @access public
	 * @return \M\Time\Date
	 */
	public function getUpdatedAt() {
		return $this->_updatedAt;
	}
	
	/**
	 * Get Property "dateDeleted"
	 * 
	 * @access public
	 * @return \M\Time\Date
	 */
	public function getDateDeleted() {
		return $this->_dateDeleted;
	}
	
}