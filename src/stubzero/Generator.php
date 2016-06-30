<?php


namespace stubzero;

/**
 * Class Generator
 *
 * @package stubzero
 * @author robotomize@gmail.com
 */
class Generator
{
    /**
     * @param $className
     *
     * @return mixed
     */
    public static function createByLexical($className)
    {
        $creator = new Creator($className);
        $creator->setType(Creator::LEXICAL_TYPE);
        $creator->start();

        return $creator->getFoundModel();
    }

    public static function createByVarType($className)
    {
        $creator = new Creator($className);
        $creator->setType(Creator::VAR_TYPE);
        $creator->start();

        return $creator->getFoundModel();
    }
}
