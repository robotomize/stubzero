<?php

namespace stubzero;

/**
 * Class FakerGenerator
 *
 * @package stubzero
 * @author robotomize@gmail.com
 */
class FakerGenerator
{
    /**
     * @var ParserModel
     */
    private $parserModel;

    /**
     * FakerGenerator constructor.
     */
    public function __construct(ParserModel $model, LexicalAnalyse $analyse)
    {
        $this->parserModel = $model;
    }

    public function generate()
    {
        foreach (get_object_vars($this->parserModel) as $property => $value) {
            print $property;
        }
    }
}