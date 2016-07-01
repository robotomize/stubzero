<?php

namespace stubzero\Parsers;
use stubzero\Models\Parser;

/**
 * Class BaseTypeStubZeroParser
 * @package stubzero\Parsers
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
     * @var Parser
     */
    private $parserModel;

    /**
     * BaseTypeStubZeroParser constructor.
     *
     * @param                                   $className
     * @param array                             $properties
     * @param InterfaceAnnotateParser $parser
     */
    public function __construct($className, array $properties, InterfaceAnnotateParser $parser)
    {
        $this->properties = $properties;
        $this->annotateParser = $parser;
        $this->className = $className;
    }

    /**
     * Parse annotation to model
     */
    public function parse()
    {
        $this->parserModel = new Parser();

        foreach ($this->properties as $property => $theirValue) {
            $this->parserModel->{$property} = $this->annotateParser
                ->getPropertyAnnotations($this->className, $property)->toArray();
        }
    }

    /**
     * @return Parser
     */
    public function getParserModel()
    {
        return $this->parserModel;
    }
}