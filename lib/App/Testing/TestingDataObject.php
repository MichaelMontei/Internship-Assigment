<?php
/**
 * TestingDataObject
 * 
 * @author M
 * @package Testing
 */

namespace App\Testing;

/**
 * TestingDataObject
 * 
 * @author M
 * @package Testing
 */
abstract class TestingDataObject extends \M\DataObject\DataObject {
	/**
	 * Property "id"
	 * 
	 * @access private
	 * @var int
	 */
	private $_id;

	/**
	 * Property "name"
	 * 
	 * @access private
	 * @var string
	 */
	private $_name;

	/**
	 * Property "address"
	 * 
	 * @access private
	 * @var string
	 */
	private $_address;

	/**
	 * Property "vatNumber"
	 * 
	 * @access private
	 * @var string
	 */
	private $_vatNumber;

	/**
	 * Property "paymentTerm"
	 * 
	 * @access private
	 * @var string
	 */
	private $_paymentTerm;

	/**
	 * Property "poNumber"
	 * 
	 * @access private
	 * @var string
	 */
	private $_poNumber;

	/**
	 * Property "email"
	 * 
	 * @access private
	 * @var string
	 */
	private $_email;

	/**
	 * Property "country"
	 * 
	 * @access private
	 * @var string
	 */
	private $_country;

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
	 * @return \App\Testing\TestingDataObject
	 */
	public function setId($value) {
		$this->_id = $value; return $this;

	}
	
	/**
	 * Set Property "name"
	 * 
	 * @access public
	 * @param string $value
	 * @return \App\Testing\TestingDataObject
	 */
	public function setName($value) {
		$this->_name = $value; return $this;

	}
	
	/**
	 * Set Property "address"
	 * 
	 * @access public
	 * @param string $value
	 * @return \App\Testing\TestingDataObject
	 */
	public function setAddress($value) {
		$this->_address = $value; return $this;

	}
	
	/**
	 * Set Property "vatNumber"
	 * 
	 * @access public
	 * @param string $value
	 * @return \App\Testing\TestingDataObject
	 */
	public function setVatNumber($value) {
		$this->_vatNumber = $value; return $this;

	}
	
	/**
	 * Set Property "paymentTerm"
	 * 
	 * @access public
	 * @param string $value
	 * @return \App\Testing\TestingDataObject
	 */
	public function setPaymentTerm($value) {
		$this->_paymentTerm = $value; return $this;

	}
	
	/**
	 * Set Property "poNumber"
	 * 
	 * @access public
	 * @param string $value
	 * @return \App\Testing\TestingDataObject
	 */
	public function setPoNumber($value) {
		$this->_poNumber = $value; return $this;

	}
	
	/**
	 * Set Property "email"
	 * 
	 * @access public
	 * @param string $value
	 * @return \App\Testing\TestingDataObject
	 */
	public function setEmail($value) {
		$this->_email = $value; return $this;

	}
	
	/**
	 * Set Property "country"
	 * 
	 * @access public
	 * @param string $value
	 * @return \App\Testing\TestingDataObject
	 */
	public function setCountry($value) {
		$this->_country = $value; return $this;

	}
	
	/**
	 * Set Property "createdAt"
	 * 
	 * @access public
	 * @param \M\Time\Date $value
	 * @return \App\Testing\TestingDataObject
	 */
	public function setCreatedAt(\M\Time\Date $value = NULL) {
		$this->_createdAt = $value; return $this;

	}
	
	/**
	 * Set Property "updatedAt"
	 * 
	 * @access public
	 * @param \M\Time\Date $value
	 * @return \App\Testing\TestingDataObject
	 */
	public function setUpdatedAt(\M\Time\Date $value = NULL) {
		$this->_updatedAt = $value; return $this;

	}
	
	/**
	 * Set Property "dateDeleted"
	 * 
	 * @access public
	 * @param \M\Time\Date $value
	 * @return \App\Testing\TestingDataObject
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
	 * Get Property "name"
	 * 
	 * @access public
	 * @return string
	 */
	public function getName() {
		return $this->_name;
	}
	
	/**
	 * Get Property "address"
	 * 
	 * @access public
	 * @return string
	 */
	public function getAddress() {
		return $this->_address;
	}
	
	/**
	 * Get Property "vatNumber"
	 * 
	 * @access public
	 * @return string
	 */
	public function getVatNumber() {
		return $this->_vatNumber;
	}
	
	/**
	 * Get Property "paymentTerm"
	 * 
	 * @access public
	 * @return string
	 */
	public function getPaymentTerm() {
		return $this->_paymentTerm;
	}
	
	/**
	 * Get Property "poNumber"
	 * 
	 * @access public
	 * @return string
	 */
	public function getPoNumber() {
		return $this->_poNumber;
	}
	
	/**
	 * Get Property "email"
	 * 
	 * @access public
	 * @return string
	 */
	public function getEmail() {
		return $this->_email;
	}
	
	/**
	 * Get Property "country"
	 * 
	 * @access public
	 * @return string
	 */
	public function getCountry() {
		return $this->_country;
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