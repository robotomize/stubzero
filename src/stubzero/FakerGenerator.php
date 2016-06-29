<?php

namespace stubzero;

use Error;
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

    /**
     * @param $type
     * @return bool
     */
    private function typeBinding($type)
    {
        foreach (AnnotationTypes::$map[AnnotationTypes::VAR_TAG] as $annoType) {
             if ($annoType === $type) {
                 return $annoType;
             }
        }

        return AnnotationTypes::VAR_TYPE_STRING;
    }
    
    public function generate()
    {
        $faker = Faker\Factory::create();
        
        foreach (get_object_vars($this->parserModel) as $property => $value) {
            $fakeMethod = FactoryLexAnalyse::run($property);
            if ($fakeMethod !== false) {
                try {
                    print $faker->$fakeMethod() . PHP_EOL;
                } catch (Error $e) {
                    $annotationType = $this->typeBinding($value[AnnotationTypes::VAR_TAG]);
                    $fakeMethod = LexicalDispenser::$fakerTypesDispenserMap[$annotationType];
                    print $faker->$fakeMethod() . PHP_EOL;
                }
            } else {
                $annotationType = $this->typeBinding($value[AnnotationTypes::VAR_TAG]);
                $fakeMethod = LexicalDispenser::$fakerTypesDispenserMap[$annotationType];
                print $faker->$fakeMethod() . PHP_EOL;
            }
        }
    }
}