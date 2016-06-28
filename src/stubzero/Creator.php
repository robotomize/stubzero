<?php

namespace stubzero;


use InvalidArgumentException;
use Minime\Annotations\Cache\ArrayCache;
use Minime\Annotations\Parser;
use Minime\Annotations\Reader;
use ReflectionClass;

/**
 * Class Creator
 *
 * @package stubzero
 * @author robotomize@gmail.com
 */
class Creator
{
    /**
     * @var string
     */
    private $className;

    /**
     * @var array
     */
    private $properties = [];

    /**
     * @var array
     */
    private $parsedAnnotation = [];

    public function __construct($className)
    {
        if (!class_exists($className)) {
            throw new InvalidArgumentException('Class ' . $className . ' does not exist');
        }

        $this->className = $className;
    }

    private function getProperties()
    {
        $this->properties = (new ReflectionClass($this->className))->getDefaultProperties();
    }

    private function contentAnnotation()
    {
        $reader = new Reader(new Parser, new ArrayCache);
        foreach ($this->properties as $property => $theirValue) {
            $this->parsedAnnotation[] = $reader->getPropertyAnnotations($this->className, $property);
        }
    }

    private function parseLightAnnotation()
    {

    }

    public function start()
    {
        $this->getProperties();

        $this->contentAnnotation();

        var_dump($this->parsedAnnotation);
    }
}