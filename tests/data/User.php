<?php

namespace test\data;

/**
 * Class User
 *
 * @package test\data
 * @author robotomize@gmail.com
 */
class User
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $tel;

    /**
     * @var string
     */
    private $email;

    /**
     * @var int
     */
    private $verifyNum;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $updateStatus;

    /**
     * @var array
     */
    private $places;

    /**
     * @var string
     */
    private $create_date;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getCreateDate()
    {
        return $this->create_date;
    }

    /**
     * @param string $create_date
     */
    public function setCreateDate($create_date)
    {
        $this->create_date = $create_date;
    }

    /**
     * @return string
     */
    public function getUpdateStatus()
    {
        return $this->updateStatus;
    }

    /**
     * @param string $updateStatus
     */
    public function setUpdateStatus($updateStatus)
    {
        $this->updateStatus = $updateStatus;
    }

    /**
     * @return int
     */
    public function getVerifyNum()
    {
        return $this->verifyNum;
    }

    /**
     * @param int $verifyNum
     */
    public function setVerifyNum($verifyNum)
    {
        $this->verifyNum = $verifyNum;
    }

    /**
     * @return array
     */
    public function getPlaces()
    {
        return $this->places;
    }

    /**
     * @param array $places
     */
    public function setPlaces($places)
    {
        $this->places = $places;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param string $tel
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
}