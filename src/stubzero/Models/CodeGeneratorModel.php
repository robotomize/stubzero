<?php
/**
 * Created by PhpStorm.
 * User: robotomize
 * Date: 02.07.16
 * Time: 15:29
 */

namespace stubzero\Models;
use stubzero\EventEmitter\InterfaceObserver;

/**
 * Class CodeGeneratorModel
 * @package stubzero\Models
 * @author robotomize@gmail.com
 */
class CodeGeneratorModel implements InterfaceModel, InterfaceObserver
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
     * @param null $args
     */
    public function update($args = null)
    {
        $this->data[] = $args;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $dump = '';
        foreach ($this->data as $key => $value) {
            $dump .= $value . PHP_EOL;
        }
        return $dump;
    }

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
