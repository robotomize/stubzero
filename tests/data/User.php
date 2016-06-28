<?php

namespace test\data;
use SimpleSoftwareIO\QrCode\DataTypes\Email;

/**
 * Class User
 *
 * @package test\data
 * @author robotomize@gmail.com
 */
class User
{
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
    private $verify_num;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $update_status;

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
    public function getVerifyNum()
    {
        return $this->verify_num;
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
     * @param int $verify_num
     */
    public function setVerifyNum($verify_num)
    {
        $this->verify_num = $verify_num;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getUpdateStatus()
    {
        return $this->update_status;
    }

    /**
     * @param mixed $update_status
     */
    public function setUpdateStatus($update_status)
    {
        $this->update_status = $update_status;
    }
}