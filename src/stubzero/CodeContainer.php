<?php

namespace stubzero;

use Error;
use stubzero\Observable\InterfaceObserver;

/**
 * Class CodeContainer
 * @package stubzero\Models
 * @author robotomize@gmail.com
 */
class CodeContainer implements InterfaceObserver
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @var string
     */
    private $objectName;

    /**
     * @return bool
     */
    private function isHead()
    {
        $result = false;

        if (0 === count($this->data)) {
            $result = true;
        }

        return $result;
    }

    /**
     * @param null $args
     */
    public function update($args = null)
    {
        if ($this->isHead() === true) {
            $this->data[] = sprintf('$%s;', $args);
        } else {
            $this->data[] = sprintf('$%s->%s', $this->objectName, $args);
        }
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
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getObjectName()
    {
        return $this->objectName;
    }

    /**
     * @param string $objectName
     */
    public function setObjectName($objectName)
    {
        $this->objectName = $objectName;
    }
}
