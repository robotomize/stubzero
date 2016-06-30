<?php

namespace stubzero;

use Camel\CaseTransformer;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionProperty;
use stubzero\Exception\StubSetPropertyException;
use stubzero\Exception\StubZeroException;
use stubzero\Models\InterfaceModel;
use stubzero\Parsers\BaseTypeStubZeroParser;
use stubzero\Parsers\MinimeAnnotationParser;
use Camel\Format\SnakeCase;
use Camel\Format\CamelCase;

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
     * @return bool
     */
    private function isCamelCase($property)
    {
        $methodName = 'set' . ucfirst($property);
        return $this->isMethodExist($methodName);
    }

    /**
     * @param $method
     * @return bool
     */
    private function isMethodExist($method)
    {
        $result = false;

        if (method_exists($this->foundModel, $method)) {
            $result = true;
        }

        return $result;
    }


    /**
     * @param $method
     * @return bool
     */
    private function isUnderScore($property)
    {
        $transformer = new CaseTransformer(new SnakeCase(), new CamelCase());
        $methodName = 'set' . ucfirst($transformer->transform($property));

        return $this->isMethodExist($methodName);
    }

    /**
     * @param $property
     * @param $value
     */
    private function setCamelCaseFunc($property, $value)
    {
        $methodName = 'set' . ucfirst($property);
        $this->foundModel->$methodName($value);
    }

    /**
     * @param $property
     * @param $value
     */
    private function setUnderScoreToCamelCaseFunc($property, $value)
    {
        $transformer = new CaseTransformer(new SnakeCase(), new CamelCase());
        $methodName = 'set' . ucfirst($transformer->transform($property));

        $this->foundModel->{$methodName}($value);
    }

    /**
     * @param $property
     * @param $value
     */
    private function set($property, $value)
    {

        if ($this->isCamelCase($property) === true) {
            $this->setCamelCaseFunc($property, $value);
        } elseif ($this->isUnderScore($property) === true) {
            $this->setUnderScoreToCamelCaseFunc($property, $value);
        } else {
            $this->foundModel->{$property} = $value;
        }
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