<?php
/**
 * TigronInvoiceLineDataObject
 * 
 * @author M
 * @package TigronInvoiceLine
 */

namespace App\Tigron;

use M\Time\Date;

/**
 * TigronInvoiceLineDataObject
 * 
 * @author M
 * @package TigronInvoiceLine
 */
abstract class TigronInvoiceLineDataObject extends \M\DataObject\DataObject {
	/**
	 * Property "id"
	 * 
	 * @access private
	 * @var int
	 */
	private int $_id;

	/**
	 * Property "TeamLeaderId"
	 * 
	 * @access private
	 * @var string
	 */
	private string $_TeamLeaderId;

	/**
	 * Property "domain"
	 * 
	 * @access private
	 * @var string
	 */
	private string $_domain;

	/**
	 * Property "lineText"
	 * 
	 * @access private
	 * @var string
	 */
	private string $_lineText;

	/**
	 * Property "createdAt"
	 * 
	 * @access private
	 * @var Date
	 */
	private Date $_createdAt;

	/**
	 * Property "updatedAt"
	 * 
	 * @access private
	 * @var Date
	 */
	private Date $_updatedAt;

	/**
	 * Property "dateDeleted"
	 * 
	 * @access private
	 * @var Date
	 */
	private Date $_dateDeleted;

	/**
	 * Set Property "id"
	 * 
	 * @access public
	 * @param int $value
	 * @return TigronInvoiceLineDataObject
	 */
	public function setId(int $value): TigronInvoiceLineDataObject
    {
		$this->_id = $value; return $this;

	}
	
	/**
	 * Set Property "TeamLeaderId"
	 * 
	 * @access public
	 * @param string $value
	 * @return TigronInvoiceLineDataObject
	 */
	public function setTeamLeaderId(string $value): TigronInvoiceLineDataObject
    {
		$this->_TeamLeaderId = $value; return $this;

	}
	
	/**
	 * Set Property "domain"
	 * 
	 * @access public
	 * @param string $value
	 * @return TigronInvoiceLineDataObject
	 */
	public function setDomain(string $value): TigronInvoiceLineDataObject
    {
		$this->_domain = $value; return $this;

	}
	
	/**
	 * Set Property "lineText"
	 * 
	 * @access public
	 * @param string $value
	 * @return TigronInvoiceLineDataObject
	 */
	public function setLineText(string $value): TigronInvoiceLineDataObject
    {
		$this->_lineText = $value; return $this;

	}

    /**
     * Set Property "createdAt"
     *
     * @access public
     * @param Date|null $value
     * @return TigronInvoiceLineDataObject
     */
	public function setCreatedAt(Date $value = NULL): TigronInvoiceLineDataObject
    {
		$this->_createdAt = $value; return $this;

	}

    /**
     * Set Property "updatedAt"
     *
     * @access public
     * @param Date|null $value
     * @return TigronInvoiceLineDataObject
     */
	public function setUpdatedAt(Date $value = NULL): TigronInvoiceLineDataObject
    {
		$this->_updatedAt = $value; return $this;

	}

    /**
     * Set Property "dateDeleted"
     *
     * @access public
     * @param Date|null $value
     * @return TigronInvoiceLineDataObject
     */
	public function setDateDeleted(Date $value = NULL): TigronInvoiceLineDataObject
    {
		$this->_dateDeleted = $value; return $this;

	}
	
	/**
	 * Get Property "id"
	 * 
	 * @access public
	 * @return int
	 */
	public function getId(): int
    {
		return $this->_id;
	}
	
	/**
	 * Get Property "TeamLeaderId"
	 * 
	 * @access public
	 * @return string
	 */
	public function getTeamLeaderId(): string
    {
		return $this->_TeamLeaderId;
	}
	
	/**
	 * Get Property "domain"
	 * 
	 * @access public
	 * @return string
	 */
	public function getDomain(): string
    {
		return $this->_domain;
	}
	
	/**
	 * Get Property "lineText"
	 * 
	 * @access public
	 * @return string
	 */
	public function getLineText(): string
    {
		return $this->_lineText;
	}
	
	/**
	 * Get Property "createdAt"
	 * 
	 * @access public
	 * @return Date
	 */
	public function getCreatedAt(): Date
    {
		return $this->_createdAt;
	}
	
	/**
	 * Get Property "updatedAt"
	 * 
	 * @access public
	 * @return Date
	 */
	public function getUpdatedAt(): Date
    {
		return $this->_updatedAt;
	}
	
	/**
	 * Get Property "dateDeleted"
	 * 
	 * @access public
	 * @return Date
	 */
	public function getDateDeleted(): Date
    {
		return $this->_dateDeleted;
	}
	
}