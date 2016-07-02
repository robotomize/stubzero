<?php

namespace stubzero\CodeGenerator;

use stubzero\EventEmitter\InterfaceObserver;
use stubzero\Models\CodeGeneratorModel;

/**
 * Class Generator
 * @package stubzero\CodeGenerator
 * @author robotomize@gmail.com
 */
class Generator implements InterfaceObserver
{
    /**
     * @var CodeGeneratorModel
     */
    private $model;

    /**
     * Generator constructor.
     * @param $className
     */
    public function __construct($className)
    {
        $this->model = new CodeGeneratorModel();
        $this->model->setClass($className);
    }

    /**
     * @param null $args
     */
    public function update($args = null)
    {
        $data = $this->model->getData();
        $data[] = $args;
        $this->model->setData($data);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $dump = '';
        foreach ($this->model->getData() as $key => $value) {
            $dump .= $value . PHP_EOL;
        }
        return $dump;
    }

    /**
     * @return CodeGeneratorModel
     */
    public function getGeneratedData()
    {
        return $this->model;
    }
}
