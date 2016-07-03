<?php

namespace stubzero;

use Camel\CaseTransformer;
use InvalidArgumentException;
use ReflectionClass;
use stubzero\Observable\InterfaceObserver;
use stubzero\Observable\InterfaceSubject;
use stubzero\Exception\StubZeroException;
use stubzero\Models\InterfaceModel;
use stubzero\AnnotationParsers\AnnotationTypes;
use stubzero\AnnotationParsers\Minime;
use Camel\Format\SnakeCase;
use Camel\Format\CamelCase;

/**
 * Class Creator
 *
 * @package stubzero
 * @author robotomize@gmail.com
 */
class Creator implements InterfaceSubject
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
     * @var array
     */
    private $observers = [];

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
     * @throws StubZeroException
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

        $parser = new AnnotationTypes($this->className, $this->properties, (new Minime()));

        $parser->parse();
        $generator = (new FakerGenerator($parser->getParserModel(), (new $this->className())));
        $generator->generate();

        $this->pullToResult($generator->getPrototypeModel());
    }

    /**
     * @param InterfaceObserver $observer
     */
    public function attach(InterfaceObserver $observer)
    {
        $this->observers[] = $observer;
    }

    /**
     * @param InterfaceObserver $observer
     */
    public function detach(InterfaceObserver $observer)
    {
        $key = array_search($observer, $this->observers, true);

        if ($key) {
            unset($this->observers[$key]);
        }
    }

    /**
     * @param null $args
     */
    public function notify($args = null)
    {
        foreach ($this->observers as $value) {
            $value->update($args);
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
     * @param $property
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
     * @return string
     */
    private function setCamelCaseFunc($property)
    {
        $methodName = 'set' . ucfirst($property);
        return $methodName;
    }

    /**
     * @param $property
     * @return string
     */
    private function setUnderScoreToCamelCaseFunc($property)
    {
        $transformer = new CaseTransformer(new SnakeCase(), new CamelCase());
        return 'set' . ucfirst($transformer->transform($property));
    }

    /**
     * @param $value
     * @param $property
     * @param null $methodName
     */
    private function createMethodNameNotification($value, $property, $methodName = null)
    {
        if ($methodName === null) {
            if (is_int($value)) {
                $resultString = sprintf('%s = %s;', $property, $value);
            } elseif (is_array($value)) {
                $toString = '[';
                $values = "'" . implode("','", $value) . "'";
                $toString .= $values . '];';
                $resultString = sprintf('%s = \'%s\';', $property, $toString);
            } else {
                $resultString = sprintf('%s = \'%s\';', $property, $value);
            }
        } elseif (is_array($value)) {
            $toString = '[';
            $values = "'" . implode("','", $value) . "'";
            $toString .= $values . '];';
            $resultString = sprintf('%s(\'%s\');', $methodName, $toString);
        } else {
            if (is_int($value)) {
                $resultString = sprintf('%s(%s);', $methodName, $value);
            } elseif ($value instanceof \DateTime) {
                $resultString = sprintf('%s(\'%s\');', $methodName, $value->format('Y-m-d H:i'));
            } else {
                $resultString = sprintf('%s(\'%s\');', $methodName, $value);
            }
        }

        $this->notify($resultString);
    }

    /**
     * @param $property
     * @param $value
     */
    private function set($property, $value)
    {
        $methodName = null;

        if ($this->isCamelCase($property) === true) {
            $this->foundModel->{$this->setCamelCaseFunc($property)}($value);
            $methodName = $this->setCamelCaseFunc($property);
        } elseif ($this->isUnderScore($property) === true) {
            $this->foundModel->{$this->setUnderScoreToCamelCaseFunc($property)}($value);
            $methodName = $this->setUnderScoreToCamelCaseFunc($property);
        } else {
            $this->foundModel->{$property} = $value;
        }

        $this->createMethodNameNotification($value, $property, $methodName);
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
