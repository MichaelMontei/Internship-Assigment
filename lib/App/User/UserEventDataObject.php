<?php namespace App\User;

use M\Time\Date;
use App\Shared\Interfaces\DefinesObjectWithTimestamps;

class UserEventDataObject extends \M\DataObject\DataObject implements DefinesObjectWithTimestamps
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $userId;

    /**
     * @var string
     */
    private $action;

    /**
     * @var string
     */
    private $objectMapper;

    /**
     * @var int
     */
    private $objectId;

    /**
     * @var Date
     */
    private $createdAt;

    /**
     * @var Date
     */
    private $updatedAt;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return UserEventDataObject
     */
    public function setId(int $id): UserEventDataObject
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return UserEventDataObject
     */
    public function setUserId(int $userId): UserEventDataObject
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param string $action
     * @return UserEventDataObject
     */
    public function setAction(string $action): UserEventDataObject
    {
        $this->action = $action;
        return $this;
    }

    /**
     * @return string
     */
    public function getObjectMapper(): string
    {
        return $this->objectMapper;
    }

    /**
     * @param string $objectMapper
     * @return UserEventDataObject
     */
    public function setObjectMapper(string $objectMapper): UserEventDataObject
    {
        $this->objectMapper = $objectMapper;
        return $this;
    }

    /**
     * @return int
     */
    public function getObjectId(): int
    {
        return $this->objectId;
    }

    /**
     * @param int $objectId
     * @return UserEventDataObject
     */
    public function setObjectId(int $objectId): UserEventDataObject
    {
        $this->objectId = $objectId;
        return $this;
    }


    /**
     * Get Property "createdAt"
     *
     * @access public
     * @return \M\Time\Date
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set Property "createdAt"
     *
     * @access public
     * @param \M\Time\Date $value
     * @return $this
     */
    public function setCreatedAt(\M\Time\Date $value = null)
    {
        $this->createdAt = $value;
        return $this;
    }

    /**
     * Get Property "updatedAt"
     *
     * @access public
     * @return \M\Time\Date
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set Property "updatedAt"
     *
     * @access public
     * @param \M\Time\Date $value
     * @return $this
     */
    public function setUpdatedAt(\M\Time\Date $value = null)
    {
        $this->updatedAt = $value;
        return $this;
    }
}