<?php
/**
 * RoleDataObject
 *
 * @author M
 * @package Role
 */

namespace App\Acl;

use M\DataObject\DataObject;
use M\Time\Date;

/**
 * RoleDataObject
 *
 * @author M
 * @package Role
 */
abstract class RoleDataObject extends DataObject
{
    /**
     * Property "id"
     *
     * @access private
     * @var int
     */
    private $_id;

    /**
     * Property "realm"
     *
     * @access private
     * @var string
     */
    private $_realm;

    /**
     * Property "createdAt"
     *
     * @access private
     * @var Date
     */
    private $_createdAt;

    /**
     * Property "updatedAt"
     *
     * @access private
     * @var Date
     */
    private $_updatedAt;

    /**
     * Set Property "id"
     *
     * @access public
     * @param int $value
     * @return \App\Acl\RoleDataObject
     */
    public function setId($value)
    {
        $this->_id = $value;
        return $this;

    }

    /**
     * Set Property "title"
     *
     * @access public
     * @param string $value
     * @param string $locale
     * @return \App\Acl\RoleDataObject
     */
    public function setTitle($value, $locale = NULL)
    {
        $this->_setLocalizedText('title', $value, $locale);
        return $this;

    }

    /**
     * @param string $realm
     * @return RoleDataObject
     */
    public function setRealm(string $realm): RoleDataObject
    {
        $this->_realm = $realm;
        return $this;
    }

    /**
     * Set Property "createdAt"
     *
     * @access public
     * @param Date $value
     * @return \App\Acl\RoleDataObject
     */
    public function setCreatedAt(Date $value = NULL)
    {
        $this->_createdAt = $value;
        return $this;

    }

    /**
     * Set Property "updatedAt"
     *
     * @access public
     * @param Date $value
     * @return \App\Acl\RoleDataObject
     */
    public function setUpdatedAt(Date $value = NULL)
    {
        $this->_updatedAt = $value;
        return $this;

    }

    /**
     * Get Property "id"
     *
     * @access public
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Get Property "title"
     *
     * @access public
     * @param string $locale
     * @return string
     */
    public function getTitle($locale = NULL)
    {
        return $this->_getLocalizedTextWithPriority('title', $locale);
    }

    /**
     * @return string
     */
    public function getRealm(): string
    {
        return $this->_realm;
    }

    /**
     * Get Property "createdAt"
     *
     * @access public
     * @return Date
     */
    public function getCreatedAt()
    {
        return $this->_createdAt;
    }

    /**
     * Get Property "updatedAt"
     *
     * @access public
     * @return Date
     */
    public function getUpdatedAt()
    {
        return $this->_updatedAt;
    }

}