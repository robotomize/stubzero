<?php

namespace stubzero;

/**
 * Class AnnotationTypes
 *
 * @package stubzero
 * @author robotomzie@gmail.com
 */
class AnnotationTypes
{
    const VAR_TAG = 'var';

    const VAR_TYPE_STRING = 'string';

    const VAR_TYPE_INT = 'int';

    const VAR_TYPE_ARRAY = 'array';

    const VAR_TYPE_FLOAT = 'float';

    const VAR_TYPE_BOOL = 'bool';

    const VAR_TYPE_BOOLEAN = 'boolean';

    const VAR_TYPE_INTEGER = 'integer';

    const VAR_TYPE_NULL = 'null';

    /**
     * @var array
     */
    public static $map = [
        AnnotationTypes::VAR_TAG => [
            AnnotationTypes::VAR_TYPE_NULL,
            AnnotationTypes::VAR_TYPE_STRING,
            AnnotationTypes::VAR_TYPE_INT,
            AnnotationTypes::VAR_TYPE_FLOAT,
            AnnotationTypes::VAR_TYPE_ARRAY
        ]
    ];

    /**
     * @param $tag
     * @return bool
     */
    public static function isTag($tag)
    {
        $result = true;

        if (!array_key_exists($tag, AnnotationTypes::$map)) {
            $result = false;
        }
        return $result;
    }
}