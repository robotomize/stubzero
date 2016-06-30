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
    public static function create($className)
    {
        $creator = new Creator($className);
        $creator->start();

        return $creator->getFoundModel();
    }
}
