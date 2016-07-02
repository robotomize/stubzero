<?php
/**
 * Created by PhpStorm.
 * User: robotomize
 * Date: 02.07.16
 * Time: 15:29
 */

namespace stubzero\Models;

/**
 * Class CodeGeneratorModel
 * @package stubzero\Models
 * @author robotomize@gmail.com
 */
class CodeGeneratorModel implements InterfaceModel
{
    /**
     * @var
     */
    private $class;

    /**
     * @var array
     */
    private $data = [];

    /**
     * @return mixed
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param mixed $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
}
