<?php


namespace stubzero\Models;

use stubzero\Exception\AnnotationTypeException;
use stubzero\Exception\ParserModelException;
use stubzero\Lexical\AnnotationTypes;

/**
 * Class ParserModel
 *
 * @package stubzero\Models
 * @author robotomize@gmail.com
 */
class ParserModel implements InterfaceModel
{
    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws ParserModelException
     */
    public function __call($name, $arguments)
    {
        if (preg_match('~^(set|get)([A-Z])(.*)$~', $name, $matches)) {
            $property = strtolower($matches[2]) . $matches[3];
            if (!property_exists($this, $property)) {
                throw new ParserModelException('Property ' . $property . ' does not exists');
            }

            switch($matches[1]) {
                case 'set':
                    $this->{ $property } = $arguments[0];
                    break;
                case 'get':
                    return $this->{ $property };
                case 'default':
                    throw new ParserModelException('Method ' . $name . ' does not exists');
            }
        }
    }

    /**
     * @param $name
     * @param $value
     * @throws AnnotationTypeException
     * @throws ParserModelException
     */
    public function __set($name, $value)
    {
        if (!is_array($value)) {
            throw new ParserModelException('Set the models value should be an array');
        }

        $filtered = [];

        foreach ($value as $k => $v) {
            if (AnnotationTypes::isTag($k) === true) {
                $filtered[$k] = $v;
            }
        }

        if(!in_array($filtered[AnnotationTypes::VAR_TAG], AnnotationTypes::$map[AnnotationTypes::VAR_TAG], true)) {
            throw new AnnotationTypeException('Type annotation does not exist');
        }

        $this->$name = $value;
    }
}
