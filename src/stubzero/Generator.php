<?php

namespace stubzero;

use PhpParser\PrettyPrinter;
use stubzero\CodeGenerator\Manager;
use stubzero\Exception\StubZeroException;

/**
 * Class Generator
 *
 * @package stubzero
 * @author robotomize@gmail.com
 */
class Generator
{
    public static function code($path, $type = Manager::GENERATE_BY_LEXICAL)
    {
        $manager = new Manager($path, $type);
        $manager->run();
        print $manager;
    }

    /**
     * @param array $classes
     *
     * @return array
     */
    public static function generateSmartCollection(array $classes)
    {
        return self::pullToCollection($classes, 'generateSmart');
    }

    /**
     * @param array $classes
     *
     * @return array
     */
    public static function generateQuickCollection(array $classes)
    {
        return self::pullToCollection($classes, 'generateQuick');
    }

    /**
     * @param $className
     * @return mixed
     * @throws StubZeroException
     */
    public static function generateSmart($className)
    {
        $creator = new Creator($className);
        $creator->setType(Creator::LEXICAL_TYPE);
        $creator->start();

        return $creator->getFoundModel();
    }

    /**
     * @param $className
     * @return mixed
     * @throws StubZeroException
     */
    public static function generateQuick($className)
    {
        $creator = new Creator($className);
        $creator->setType(Creator::VAR_TYPE);
        $creator->start();

        return $creator->getFoundModel();
    }

    /**
     * @param array $classes
     * @param       $methodName
     *
     * @return array
     */
    private static function pullToCollection(array $classes, $methodName)
    {
        $objectCollection = [];

        foreach ($classes as $name) {
            $objectCollection[] = $methodName($name);
        }
        return $objectCollection;
    }
}
