<?php

namespace stubzero;

use InvalidArgumentException;
use ReflectionClass;
use stubzero\Exception\StubZeroException;
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
    const LEXICAL_TYPE = 'mixed';

    const VAR_TYPE = 'var';

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

    /**
     * @var string
     */
    private $type = Creator::LEXICAL_TYPE;

    /**
     * Creator constructor.
     * @param $className
     */
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

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        if (in_array($type, [Creator::LEXICAL_TYPE, Creator::VAR_TYPE], true)) {
            $this->type = $type;
        } else {
            throw new StubZeroException('You set a not existing type analyzer');
        }
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
    private function set($property, $value)
    {
        $methodName = 'set' . ucfirst($property);
        method_exists($this->foundModel, $methodName)
            ? $this->foundModel->$methodName($value) : $this->foundModel->{$property} = $value;
    }

    /**
     * @param $property
     * @return mixed
     */
    public function get($property)
    {
        $methodName = 'get' . ucfirst($property);
        return method_exists($this->foundModel, $methodName)
            ? $this->foundModel->$methodName() : $this->foundModel->{$property};
    }

    /**
     * @param InterfaceModel $model
     */
    private function pullToResult(InterfaceModel $model)
    {
        foreach (get_object_vars($model) as $property => $value) {
            $this->set($property, $value);
        }
    }
}