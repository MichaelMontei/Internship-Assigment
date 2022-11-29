<?php
/**
 * StarwarsDataObject
 * 
 * @author M
 * @package Starwars
 */

namespace App\Starwars;

/**
 * StarwarsDataObject
 * 
 * @author M
 * @package Starwars
 */
abstract class StarwarsDataObject extends \M\DataObject\DataObject {
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
	 * Property "height"
	 * 
	 * @access private
	 * @var int
	 */
	private $_height;

	/**
	 * Property "gender"
	 * 
	 * @access private
	 * @var string
	 */
	private $_gender;

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
	 * @return \App\Starwars\StarwarsDataObject
	 */
	public function setId($value) {
		$this->_id = $value; return $this;

	}
	
	/**
	 * Set Property "name"
	 * 
	 * @access public
	 * @param string $value
	 * @return \App\Starwars\StarwarsDataObject
	 */
	public function setName($value) {
		$this->_name = $value; return $this;

	}
	
	/**
	 * Set Property "height"
	 * 
	 * @access public
	 * @param int $value
	 * @return \App\Starwars\StarwarsDataObject
	 */
	public function setHeight($value) {
		$this->_height = $value; return $this;

	}
	
	/**
	 * Set Property "gender"
	 * 
	 * @access public
	 * @param string $value
	 * @return \App\Starwars\StarwarsDataObject
	 */
	public function setGender($value) {
		$this->_gender = $value; return $this;

	}
	
	/**
	 * Set Property "createdAt"
	 * 
	 * @access public
	 * @param \M\Time\Date $value
	 * @return \App\Starwars\StarwarsDataObject
	 */
	public function setCreatedAt(\M\Time\Date $value = NULL) {
		$this->_createdAt = $value; return $this;

	}
	
	/**
	 * Set Property "updatedAt"
	 * 
	 * @access public
	 * @param \M\Time\Date $value
	 * @return \App\Starwars\StarwarsDataObject
	 */
	public function setUpdatedAt(\M\Time\Date $value = NULL) {
		$this->_updatedAt = $value; return $this;

	}
	
	/**
	 * Set Property "dateDeleted"
	 * 
	 * @access public
	 * @param \M\Time\Date $value
	 * @return \App\Starwars\StarwarsDataObject
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
	 * Get Property "height"
	 * 
	 * @access public
	 * @return int
	 */
	public function getHeight() {
		return $this->_height;
	}
	
	/**
	 * Get Property "gender"
	 * 
	 * @access public
	 * @return string
	 */
	public function getGender() {
		return $this->_gender;
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