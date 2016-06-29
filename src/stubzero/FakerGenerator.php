<?php

namespace stubzero;

use Faker;

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
    public function __construct(ParserModel $model)
    {
        $this->parserModel = $model;
    }

    public function generate()
    {
        $faker = Faker\Factory::create();
        
        foreach (get_object_vars($this->parserModel) as $property => $value) {
            $fakeMethod = FactoryLexAnalyse::run($property);
            if ($fakeMethod !== false) {
                print $fakeMethod;
            }
        }
    }
}