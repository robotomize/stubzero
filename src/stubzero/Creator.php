<?php

namespace stubzero;

use InvalidArgumentException;
use ReflectionClass;
use stubzero\Models\InterfaceModel;
use stubzero\Parsers\BaseTypeStubZeroParser;
use stubzero\Parsers\MinimeAnnotationParser;

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
     * @var
     */
    private $foundModel;

    /**
     * @var array
     */
    private $properties = [];

    public function __construct($className)
    {
        if (!class_exists($className)) {
            throw new InvalidArgumentException('Class ' . $className . ' does not exist');
        }

        $this->className = $className;
        $this->foundModel = new $this->className();
    }

    private function getProperties()
    {
        $this->properties = (new ReflectionClass($this->className))->getDefaultProperties();
    }

    public function start()
    {
        $this->getProperties();

        $parser = new BaseTypeStubZeroParser($this->className, $this->properties, (new MinimeAnnotationParser()));

        $parser->parse();
        $generator = (new FakerGenerator($parser->getParserModel(), (new $this->className())));
        $generator->generate();

        $this->pullToResult($generator->getPrototypeModel());
    }

    /**
     * @return mixed
     */
    public function getFoundModel()
    {
        return $this->foundModel;
    }

    /**
     * @param $property
     *
     * @return string
     */
    private function set($property)
    {
        return sprintf('set%s%s', mb_strtoupper($property{0}), mb_substr($property, 1));
    }

    /**
     * @param InterfaceModel $model
     */
    private function pullToResult(InterfaceModel $model)
    {
        foreach (get_object_vars($model) as $property => $value) {
            $methodName = $this->set($property);
            $this->foundModel->$methodName($value);
        }
    }
}