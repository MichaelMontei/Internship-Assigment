<?php
/**
 * UserDataObject
 *
 * @author M
 * @package User
 */

namespace App\User;

/**
 * UserDataObject
 *
 * @author M
 * @package User
 */
abstract class UserDataObject extends \M\DataObject\DataObject
{
    /**
     * Property "id"
     *
     * @access private
     * @var int
     */
    private $_id;

    /**
     * Property "email"
     *
     * @access private
     * @var string
     */
    private $_email;

    /**
     * Property "password"
     *
     * @access private
     * @var string
     */
    private $_password;

    /**
     * Property "token"
     *
     * @access private
     * @var string
     */
    private $_token;

    /**
     * Property "firstName"
     *
     * @access private
     * @var string
     */
    private $_firstName;

    /**
     * Property "surname"
     *
     * @access private
     * @var string
     */
    private $_surname;

    /**
     * Property "company"
     *
     * @access private
     * @var string
     */
    private $_company;

    /**
     * Property "locale"
     *
     * @access private
     * @var string
     */
    private $_locale;

    /**
     * Property "roleId"
     *
     * @access private
     * @var int
     */
    private $_roleId;

    /**
     * Property "active"
     *
     * @access private
     * @var int
     */
    private $_active;

    /**
     * Property "dateCreated"
     *
     * @access private
     * @var \M\Time\Date
     */
    private $_dateCreated;

    /**
     * Property "dateLastLogin"
     *
     * @access private
     * @var \M\Time\Date
     */
    private $_dateLastLogin;

    /**
     * Property "dateLastVisit"
     *
     * @access private
     * @var \M\Time\Date
     */
    private $_dateLastVisit;

    /**
     * Property "datePreviousVisit"
     *
     * @access private
     * @var \M\Time\Date
     */
    private $_datePreviousVisit;

    /**
     * Set Property "id"
     *
     * @access public
     * @param int $value
     * @return \App\User\UserDataObject
     */
    public function setId($value)
    {
        $this->_id = $value;
        return $this;

    }

    /**
     * Set Property "email"
     *
     * @access public
     * @param string $value
     * @return \App\User\UserDataObject
     */
    public function setEmail($value)
    {
        $this->_email = $value;
        return $this;

    }

    /**
     * Set Property "password"
     *
     * @access public
     * @param string $value
     * @return \App\User\UserDataObject
     */
    public function setPassword($value)
    {
        $this->_password = $value;
        return $this;

    }

    /**
     * Set Property "token"
     *
     * @access public
     * @param string $value
     * @return \App\User\UserDataObject
     */
    public function setToken($value)
    {
        $this->_token = $value;
        return $this;

    }

    /**
     * Set Property "firstName"
     *
     * @access public
     * @param string $value
     * @return \App\User\UserDataObject
     */
    public function setFirstName($value)
    {
        $this->_firstName = $value;
        return $this;

    }

    /**
     * Set Property "surname"
     *
     * @access public
     * @param string $value
     * @return \App\User\UserDataObject
     */
    public function setSurname($value)
    {
        $this->_surname = $value;
        return $this;

    }

    /**
     * Set Property "company"
     *
     * @access public
     * @param string $value
     * @return \App\User\UserDataObject
     */
    public function setCompany($value)
    {
        $this->_company = $value;
        return $this;

    }

    /**
     * Set Property "locale"
     *
     * @access public
     * @param string $value
     * @return \App\User\UserDataObject
     */
    public function setLocale($value)
    {
        $this->_locale = $value;
        return $this;

    }

    /**
     * Set Property "roleId"
     *
     * @access public
     * @param int $value
     * @return \App\User\UserDataObject
     */
    public function setRoleId($value)
    {
        $this->_roleId = $value;
        return $this;

    }

    /**
     * Set Property "active"
     *
     * @access public
     * @param int $value
     * @return \App\User\UserDataObject
     */
    public function setActive($value)
    {
        $this->_active = $value;
        return $this;

    }

    /**
     * Set Property "dateCreated"
     *
     * @access public
     * @param \M\Time\Date $value
     * @return \App\User\UserDataObject
     */
    public function setDateCreated(\M\Time\Date $value)
    {
        $this->_dateCreated = $value;
        return $this;

    }

    /**
     * Set Property "dateLastLogin"
     *
     * @access public
     * @param \M\Time\Date $value
     * @return \App\User\UserDataObject
     */
    public function setDateLastLogin(\M\Time\Date $value = NULL)
    {
        $this->_dateLastLogin = $value;
        return $this;

    }

    /**
     * Set Property "dateLastVisit"
     *
     * @access public
     * @param \M\Time\Date $value
     * @return \App\User\UserDataObject
     */
    public function setDateLastVisit(\M\Time\Date $value = NULL)
    {
        $this->_dateLastVisit = $value;
        return $this;

    }

    /**
     * Set Property "datePreviousVisit"
     *
     * @access public
     * @param \M\Time\Date $value
     * @return \App\User\UserDataObject
     */
    public function setDatePreviousVisit(\M\Time\Date $value = NULL)
    {
        $this->_datePreviousVisit = $value;
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
     * Get Property "email"
     *
     * @access public
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * Get Property "password"
     *
     * @access public
     * @return string
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * Get Property "token"
     *
     * @access public
     * @return string
     */
    public function getToken()
    {
        return $this->_token;
    }

    /**
     * Get Property "firstName"
     *
     * @access public
     * @return string
     */
    public function getFirstName()
    {
        return $this->_firstName;
    }

    /**
     * Get Property "surname"
     *
     * @access public
     * @return string
     */
    public function getSurname()
    {
        return $this->_surname;
    }

    /**
     * Get Property "company"
     *
     * @access public
     * @return string
     */
    public function getCompany()
    {
        return $this->_company;
    }

    /**
     * Get Property "locale"
     *
     * @access public
     * @return string
     */
    public function getLocale()
    {
        return $this->_locale;
    }

    /**
     * Get Property "roleId"
     *
     * @access public
     * @return int
     */
    public function getRoleId()
    {
        return $this->_roleId;
    }

    /**
     * Get Property "active"
     *
     * @access public
     * @return int
     */
    public function getActive()
    {
        return $this->_active;
    }

    /**
     * Get Property "dateCreated"
     *
     * @access public
     * @return \M\Time\Date
     */
    public function getDateCreated()
    {
        return $this->_dateCreated;
    }

    /**
     * Get Property "dateLastLogin"
     *
     * @access public
     * @return \M\Time\Date
     */
    public function getDateLastLogin()
    {
        return $this->_dateLastLogin;
    }

    /**
     * Get Property "dateLastVisit"
     *
     * @access public
     * @return \M\Time\Date
     */
    public function getDateLastVisit()
    {
        return $this->_dateLastVisit;
    }

    /**
     * Get Property "datePreviousVisit"
     *
     * @access public
     * @return \M\Time\Date
     */
    public function getDatePreviousVisit()
    {
        return $this->_datePreviousVisit;
    }

}