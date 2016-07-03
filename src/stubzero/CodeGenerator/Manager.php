<?php

namespace stubzero\CodeGenerator;

use Error;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\Use_;
use PhpParser\ParserFactory;
use ReflectionClass;
use stubzero\ClassCrawler;
use stubzero\CodeContainer;
use stubzero\Creator;
use stubzero\Exception\StubZeroException;

/**
 * Class Manager
 * @package stubzero\CodeGenerator
 * @author robotomize@gmail.com
 */
class Manager
{
    const GENERATE_BY_LEXICAL = 'smart';

    const GENERATE_BY_TYPE = 'types';

    /**
     * @var array
     */
    private $collection = [];

    /**
     * @var array
     */
    private $files = [];

    /**
     * @var string
     */
    private $path;

    /**
     * @var array
     */
    private $uses = [];

    /**
     * @var string
     */
    private $extend;

    /**
     * @var array
     */
    private $nameNumberMap = [];

    /**
     * Manager constructor.
     *
     * @throws StubZeroException
     * @param $path
     * @param $type
     */
    public function __construct($path, $type)
    {
        $this->path = $path;

        if (!in_array($type, [Manager::GENERATE_BY_LEXICAL, Manager::GENERATE_BY_TYPE])) {
            throw new StubZeroException('Type of generation does not exist');
        }

        $this->generateType = $type;
    }

    /**
     * @throws StubZeroException
     */
    public function run()
    {
        $crawler = new ClassCrawler($this->path);
        $crawler->start();

        $this->files = $crawler->getFiles();

        foreach ($this->files as $filename) {

            $className = $this->createClassName($filename);

            if ($this->extend !== null) {
                print $this->path . DIRECTORY_SEPARATOR . $this->extend . '.php';
                require_once $this->path . DIRECTORY_SEPARATOR . $this->extend . '.php';
            }

            require_once $filename;
            $reflector = new ReflectionClass($className);
            if (!$reflector->isAbstract()
                && !$reflector->isInterface() && !$reflector->isTrait() && !$reflector->isAnonymous()) {
                //$model = new $className();
                $codeModel = new CodeContainer();
                $codeModel->update($this->createObjectName($className, $codeModel));


                $creator = new Creator($className);
                $creator->attach($codeModel);
                $creator->setType(Creator::LEXICAL_TYPE);
                $creator->start();


                $this->collection[] = $codeModel;
            }
            $this->uses = [];
            $this->extend = null;
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $resultString = '';
        foreach ($this->collection as $codeContainer) {
            /** @var $codeContainer CodeContainer */
            $resultString .= $codeContainer;
        }

        return $resultString;
    }

    /**
     * @param $fileName
     * @return string
     */
    private function createClassName($fileName)
    {
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $code = file_get_contents($fileName);
        $stmts = $parser->parse($code);

        $className = '';
        $nameSpaceName = '';

        foreach ($stmts as $val) {
            if ($val instanceof Namespace_) {
                $nameSpaceName = $val->{'name'};
                break;
            }
        }

        foreach ($stmts[0]->{'stmts'} as $k => $v) {
            $className = $v;
            //var_dump($className);
            if ($className instanceof Class_) {
                print 'mom' . $className->extends . PHP_EOL;
                if ($className->extends !== null) {
                    $this->extend = $className->extends;
                }
                $className = $className->{'name'};
                break;
            }
        }

        $className = $nameSpaceName . '\\' . $className;
        return $className;
    }

    /**
     * @param $className
     * @return mixed|string
     */
    private function createObjectName($className, CodeContainer $codeModel)
    {
        $tailName = explode('\\', $className);
        $objectName = mb_strtolower(array_pop($tailName));

        if ($this->isUniqueName($objectName) === false) {
            if (array_key_exists($objectName, $this->nameNumberMap) === true) {
                $this->nameNumberMap[$objectName] = ++$this->nameNumberMap[$objectName];
            } else {
                $this->nameNumberMap[$objectName] = 1;
            }
            $objectName = $objectName . $this->nameNumberMap[$objectName];
        }

        $codeModel->setObjectName($objectName);
        return sprintf('%s = new %s()', $objectName, $className);
    }

    /**
     * @param $name
     * @return bool
     */
    private function isUniqueName($name)
    {
        return array_key_exists($name, $this->collection) === true ? false : true;
    }
}
