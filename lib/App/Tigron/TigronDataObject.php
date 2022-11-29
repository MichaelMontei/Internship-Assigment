<?php
/**
 * TigronDataObject
 * 
 * @author M
 * @package Tigron
 */

namespace App\Tigron;

/**
 * TigronDataObject
 * 
 * @author M
 * @package Tigron
 */
abstract class TigronDataObject extends \M\DataObject\DataObject {
	/**
	 * Property "id"
	 * 
	 * @access private
	 * @var int
	 */
	private $_id;

	/**
	 * Property "username"
	 * 
	 * @access private
	 * @var string
	 */
	private $_username;

	/**
	 * Property "customer"
	 * 
	 * @access private
	 * @var string
	 */
	private $_customer;

	/**
	 * Property "productDescription"
	 * 
	 * @access private
	 * @var string
	 */
	private $_productDescription;

	/**
	 * Property "price"
	 * 
	 * @access private
	 * @var float
	 */
	private $_price;

	/**
	 * Property "ignore"
	 * 
	 * @access private
	 * @var int
	 */
	private $_ignore;

	/**
	 * Property "teamleaderInvoiceNumber"
	 * 
	 * @access private
	 * @var string
	 */
	private $_teamleaderInvoiceNumber;

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
	 * @return \App\Tigron\TigronDataObject
	 */
	public function setId($value) {
		$this->_id = $value; return $this;

	}
	
	/**
	 * Set Property "username"
	 * 
	 * @access public
	 * @param string $value
	 * @return \App\Tigron\TigronDataObject
	 */
	public function setUsername($value) {
		$this->_username = $value; return $this;

	}
	
	/**
	 * Set Property "customer"
	 * 
	 * @access public
	 * @param string $value
	 * @return \App\Tigron\TigronDataObject
	 */
	public function setCustomer($value) {
		$this->_customer = $value; return $this;

	}
	
	/**
	 * Set Property "productDescription"
	 * 
	 * @access public
	 * @param string $value
	 * @return \App\Tigron\TigronDataObject
	 */
	public function setProductDescription($value) {
		$this->_productDescription = $value; return $this;

	}
	
	/**
	 * Set Property "price"
	 * 
	 * @access public
	 * @param float $value
	 * @return \App\Tigron\TigronDataObject
	 */
	public function setPrice($value) {
		$this->_price = $value; return $this;

	}
	
	/**
	 * Set Property "ignore"
	 * 
	 * @access public
	 * @param int $value
	 * @return \App\Tigron\TigronDataObject
	 */
	public function setIgnore($value) {
		$this->_ignore = $value; return $this;

	}
	
	/**
	 * Set Property "teamleaderInvoiceNumber"
	 * 
	 * @access public
	 * @param string $value
	 * @return \App\Tigron\TigronDataObject
	 */
	public function setTeamleaderInvoiceNumber($value) {
		$this->_teamleaderInvoiceNumber = $value; return $this;

	}
	
	/**
	 * Set Property "createdAt"
	 * 
	 * @access public
	 * @param \M\Time\Date $value
	 * @return \App\Tigron\TigronDataObject
	 */
	public function setCreatedAt(\M\Time\Date $value = NULL) {
		$this->_createdAt = $value; return $this;

	}
	
	/**
	 * Set Property "updatedAt"
	 * 
	 * @access public
	 * @param \M\Time\Date $value
	 * @return \App\Tigron\TigronDataObject
	 */
	public function setUpdatedAt(\M\Time\Date $value = NULL) {
		$this->_updatedAt = $value; return $this;

	}
	
	/**
	 * Set Property "dateDeleted"
	 * 
	 * @access public
	 * @param \M\Time\Date $value
	 * @return \App\Tigron\TigronDataObject
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
	 * Get Property "username"
	 * 
	 * @access public
	 * @return string
	 */
	public function getUsername() {
		return $this->_username;
	}
	
	/**
	 * Get Property "customer"
	 * 
	 * @access public
	 * @return string
	 */
	public function getCustomer() {
		return $this->_customer;
	}
	
	/**
	 * Get Property "productDescription"
	 * 
	 * @access public
	 * @return string
	 */
	public function getProductDescription() {
		return $this->_productDescription;
	}
	
	/**
	 * Get Property "price"
	 * 
	 * @access public
	 * @return float
	 */
	public function getPrice() {
		return $this->_price;
	}
	
	/**
	 * Get Property "ignore"
	 * 
	 * @access public
	 * @return int
	 */
	public function getIgnore() {
		return $this->_ignore;
	}
	
	/**
	 * Get Property "teamleaderInvoiceNumber"
	 * 
	 * @access public
	 * @return string
	 */
	public function getTeamleaderInvoiceNumber() {
		return $this->_teamleaderInvoiceNumber;
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