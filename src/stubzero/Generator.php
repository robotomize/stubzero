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
     * @return mixed
     * @throws Exception\StubZeroException
     */
    public static function createDeep($className)
    {
        $creator = new Creator($className);
        $creator->setType(Creator::LEXICAL_TYPE);
        $creator->start();

        return $creator->getFoundModel();
    }

    /**
     * @param $className
     * @return mixed
     * @throws Exception\StubZeroException
     */
    public static function createQuick($className)
    {
        $creator = new Creator($className);
        $creator->setType(Creator::VAR_TYPE);
        $creator->start();

        return $creator->getFoundModel();
    }
}
