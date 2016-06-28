<?php


namespace stubzero;

use stubzero\Exceptions\AnnotationTypeException;
use stubzero\Exceptions\ParserModelException;

/**
 * Class ParserModel
 * @package stubzero
 * @author robotomize@sakh.com
 */
class ParserModel
{
    /**
     * @var array
     */
    private $data = [];

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
            throw new ParserModelException(sprintf('The %s must be an array', $value));
        }

        $filtered = array_filter($value, function ($k) {
            return AnnotationTypes::isTag($k);
        });

        if(!in_array($filtered[AnnotationTypes::VAR_TAG], AnnotationTypes::$map[AnnotationTypes::VAR_TAG])) {
            throw new AnnotationTypeException('Type annotation does not exist');
        }
        
        $this->data[$name] = $filtered;
    }
}
