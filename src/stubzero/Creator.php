<?php

namespace stubzero;


use InvalidArgumentException;
use Minime\Annotations\AnnotationsBag;
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
    
    private function generate()
    {
        $model = new $this->className();

        foreach ($this->parsedAnnotation as $annotationBag) {
            /** @var $annotationBag AnnotationsBag */
            print $annotationBag->get('var');
        }
    }

    public function start()
    {
        $this->getProperties();

        $parser = new BaseTypeStubZeroParser($this->className, $this->properties, (new MinimeAnnotationParser()));

        $parser->parse();


        //$this->generate();
        //var_dump($this->parsedAnnotation);
    }
}