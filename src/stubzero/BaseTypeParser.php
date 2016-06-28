<?php

namespace stubzero;

/**
 * Class BaseTypeStubZeroParser
 * @package stubzero
 * @author robotomize@gmail.com
 */
class BaseTypeStubZeroParser implements InterfaceStubZeroParser
{

    /**
     * @var array
     */
    private $properties;

    /**
     * @var InterfaceAnnotateParser
     */
    private $annotateParser;

    /**
     * @var string
     */
    private $className;

    /**
     * @var ParserModel
     */
    private $parserModel;

    /**
     * BaseTypeStubZeroParser constructor.
     * @param array $properties
     */
    public function __construct($className, array $properties, InterfaceAnnotateParser $parser)
    {
        $this->properties = $properties;
        $this->annotateParser = $parser;
        $this->className = $className;
    }

    public function parse()
    {
        $this->parserModel = new ParserModel();
        foreach ($this->properties as $property => $theirValue) {
            $this->parserModel->{$property} = $this->annotateParser
                ->getPropertyAnnotations($this->className, $property);
        }
        var_dump($this->parserModel);
    }

    /**
     * @return ParserModel
     */
    public function getParserModel()
    {
        return $this->parserModel;
    }
}