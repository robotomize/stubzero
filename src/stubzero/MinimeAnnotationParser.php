<?php

namespace stubzero;


use Minime\Annotations\Cache\ArrayCache;
use Minime\Annotations\Parser;
use Minime\Annotations\Reader;

/**
 * Class MinimeAnnotationParser
 * @package stubzero
 * @author robotomize@gmail.com
 */
class MinimeAnnotationParser implements InterfaceAnnotateParser
{

    /**
     * @var Reader
     */
    private $reader;

    /**
     * MinimeAnnotationParser constructor.
     */
    public function __construct()
    {
        $this->reader = new Reader(new Parser, new ArrayCache);
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed|null
     */
    public function __call($name, $arguments)
    {
        $result = null;

        if (method_exists($this->reader, $name)) {
            $result =  call_user_func_array([$this->reader, $name], $arguments);
        }

        return $result;
    }
}
