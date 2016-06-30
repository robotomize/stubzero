<?php

namespace stubzero;

use Faker;
use Faker\Factory;
use stubzero\Lexical\AnnotationTypes;
use stubzero\Lexical\FactoryLexAnalyse;
use stubzero\Lexical\LexicalDispenser;
use stubzero\Models\ParserModel;
use stubzero\Models\PrototypeModel;

/**
 * Class FakerGenerator
 *
 * @package stubzero
 * @author robotomize@gmail.com
 */
class FakerGenerator
{
    const ARRAY_DIMENSION = '10';

    /**
     * @var ParserModel
     */
    private $parserModel;

    /**
     * @var Generator
     */
    private $fakerInstance;

    /**
     * @var
     */
    private $prototypeModel;

    /**
     * FakerGenerator constructor.
     * @param ParserModel $model
     */
    public function __construct(ParserModel $model)
    {
        $this->parserModel = $model;
        $this->fakerInstance = Factory::create();
        $this->prototypeModel = new PrototypeModel();
    }

    /**
     *
     */
    public function generate()
    {
        foreach (get_object_vars($this->parserModel) as $property => $value) {
            $fakeMethod = FactoryLexAnalyse::run($property);
            if ($fakeMethod !== null) {
                $this->prototypeModel->{$property} = $this->fakerInstance->$fakeMethod();
            } else {
                $this->prototypeModel->{$property} = $this->callFakerMethodByTypeBiding($value);
            }
        }
    }

    /**
     * @return mixed
     */
    public function getPrototypeModel()
    {
        return $this->prototypeModel;
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

    /**
     * @param string $type
     *
     * @return array
     */
    private function isArray($type = 'assoc')
    {
        $result = range(0, self::ARRAY_DIMENSION);

        foreach ($result as $k => $v) {
            $result[$k] = $type === 'assoc'
                ? $this->fakerInstance->{ LexicalDispenser::$fakerTypesDispenserMap[AnnotationTypes::VAR_TYPE_STRING] }
                : $this->fakerInstance{ LexicalDispenser::FAKER_NUMBER };
        }

        return $result;
    }

    /**
     * @param $value
     *
     * @return array
     */
    private function callFakerMethodByTypeBiding($value)
    {
        $annotationType = $this->typeBinding($value[AnnotationTypes::VAR_TAG]);

        if ($annotationType === AnnotationTypes::VAR_TYPE_ARRAY) {
            $result = $this->isArray();
        } else {
            $fakeMethod = LexicalDispenser::$fakerTypesDispenserMap[$annotationType];
            $result = $this->fakerInstance->$fakeMethod();
        }

        return $result;
    }
}