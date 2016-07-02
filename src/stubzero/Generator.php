<?php

namespace stubzero;

use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter;
/**
 * Class Generator
 *
 * @package stubzero
 * @author robotomize@gmail.com
 */
class Generator
{
    public static function code($path)
    {
        $crawler = new ClassCrawler($path);
        $crawler->start();
        $files = $crawler->getFiles();

        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $prettyPrinter = new PrettyPrinter\Standard;
        $traverser     = new NodeTraverser;

        foreach ($files as $filename) {
            require_once $filename;

            $code = file_get_contents($filename);

            $stmts = $parser->parse($code);

            $ns = $stmts[0]->{'name'};

            $className = $stmts[0]->{'stmts'}[0]->{'name'};

            $className = $ns . '\\' . $className;
            $obj = new $className();
            var_dump($obj);
            //$stmts->
            //var_dump($stmts);

            // pretty print
            //$code = $prettyPrinter->prettyPrintFile($stmts);

            //echo $code;

//
//            $t = explode(".",$filename);
//            $obj = strtolower($t[1]);
//            $class = ucfirst($t[1]);
//            ${$obj} = new $class();
//            var_dump(${$obj});
        }
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
     * @throws Exception\StubZeroException
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
     * @throws Exception\StubZeroException
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
