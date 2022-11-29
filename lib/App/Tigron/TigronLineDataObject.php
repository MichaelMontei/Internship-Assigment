<?php
/**
 * TigronLineDataObject
 * 
 * @author M
 * @package TigronLine
 */

namespace App\Tigron;

/**
 * TigronLineDataObject
 * 
 * @author M
 * @package TigronLine
 */
abstract class TigronLineDataObject extends \M\DataObject\DataObject {
	/**
	 * Property "id"
	 * 
	 * @access private
	 * @var int
	 */
	private $_id;

	/**
	 * Property "clientId"
	 * 
	 * @access private
	 * @var int
	 */
	private $_clientId;

	/**
	 * Property "invoiceNumber"
	 * 
	 * @access private
	 * @var int
	 */
	private $_invoiceNumber;

	/**
	 * Property "name"
	 * 
	 * @access private
	 * @var string
	 */
	private $_name;

	/**
	 * Property "statusCode"
	 * 
	 * @access private
	 * @var int
	 */
	private $_statusCode;

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
	 * @return \App\Tigron\TigronLineDataObject
	 */
	public function setId($value) {
		$this->_id = $value; return $this;

	}
	
	/**
	 * Set Property "clientId"
	 * 
	 * @access public
	 * @param int $value
	 * @return \App\Tigron\TigronLineDataObject
	 */
	public function setClientId($value) {
		$this->_clientId = $value; return $this;

	}
	
	/**
	 * Set Property "invoiceNumber"
	 * 
	 * @access public
	 * @param int $value
	 * @return \App\Tigron\TigronLineDataObject
	 */
	public function setInvoiceNumber($value) {
		$this->_invoiceNumber = $value; return $this;

	}
	
	/**
	 * Set Property "name"
	 * 
	 * @access public
	 * @param string $value
	 * @return \App\Tigron\TigronLineDataObject
	 */
	public function setName($value) {
		$this->_name = $value; return $this;

	}
	
	/**
	 * Set Property "statusCode"
	 * 
	 * @access public
	 * @param int $value
	 * @return \App\Tigron\TigronLineDataObject
	 */
	public function setStatusCode($value) {
		$this->_statusCode = $value; return $this;

	}
	
	/**
	 * Set Property "createdAt"
	 * 
	 * @access public
	 * @param \M\Time\Date $value
	 * @return \App\Tigron\TigronLineDataObject
	 */
	public function setCreatedAt(\M\Time\Date $value = NULL) {
		$this->_createdAt = $value; return $this;

	}
	
	/**
	 * Set Property "updatedAt"
	 * 
	 * @access public
	 * @param \M\Time\Date $value
	 * @return \App\Tigron\TigronLineDataObject
	 */
	public function setUpdatedAt(\M\Time\Date $value = NULL) {
		$this->_updatedAt = $value; return $this;

	}
	
	/**
	 * Set Property "dateDeleted"
	 * 
	 * @access public
	 * @param \M\Time\Date $value
	 * @return \App\Tigron\TigronLineDataObject
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
	 * Get Property "clientId"
	 * 
	 * @access public
	 * @return int
	 */
	public function getClientId() {
		return $this->_clientId;
	}
	
	/**
	 * Get Property "invoiceNumber"
	 * 
	 * @access public
	 * @return int
	 */
	public function getInvoiceNumber() {
		return $this->_invoiceNumber;
	}
	
	/**
	 * Get Property "name"
	 * 
	 * @access public
	 * @return string
	 */
	public function getName() {
		return $this->_name;
	}
	
	/**
	 * Get Property "statusCode"
	 * 
	 * @access public
	 * @return int
	 */
	public function getStatusCode() {
		return $this->_statusCode;
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