<?php

namespace test\data;

/**
 * Class Order
 * @package SakhCom\Tickets\Models
 * @author robotomize@sakh.com
 */
class Order
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    protected $code;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var int
     */
    protected $user_id;

    /**
     * @var string
     */
    protected $summ;

    /**
     * @var int
     */
    protected $sale_id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $email;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getSumm()
    {
        return $this->summ;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @param string $create_date
     */
    public function setCreateDate($create_date)
    {
        $this->createDate = $create_date;
    }

    /**
     * @param string $update_date
     */
    public function setUpdateDate($update_date)
    {
        $this->updateDate = $update_date;
    }

    /**
     * @param int $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @param string $summ
     */
    public function setSumm($summ)
    {
        $this->summ = $summ;
    }

    /**
     * @return int
     */
    public function getSaleId()
    {
        return $this->sale_id;
    }

    /**
     * @param int $sale_id
     */
    public function setSaleId($sale_id)
    {
        $this->sale_id = $sale_id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
}
