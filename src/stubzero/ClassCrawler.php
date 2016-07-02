<?php

namespace stubzero;
use InvalidArgumentException;
use stubzero\Exception\StubZeroException;
use stubzero\Models\ClassProperty;

/**
 * Class ClassCrawler
 *
 * @package stubzero
 * @author robotomize@gmail.com
 */
class ClassCrawler
{

    /**
     * @var string
     */
    private $path;

    /**
     * @var bool
     */
    private $recursive = false;

    /**
     * @var array
     */
    private $grabbedClasses = [];

    /**
     * ClassCrawler constructor.
     *
     * @param            $path
     * @param bool|false $recursive
     */
    public function __construct($path, $recursive = false)
    {

        if (is_dir($path)) {
            $this->path = $path;
        } else {
            throw new InvalidArgumentException('Directory ' . $path . ' not found');
        }

        $this->recursive = (bool)$recursive;
    }

    public function start()
    {
        foreach (scandir($this->path) as $key => $className) {
            $fileName = $this->path . DIRECTORY_SEPARATOR . $className;
            if (is_file($fileName)) {
                if (file_exists($fileName) && $className !== '.' && $className !== '..') {
                    $this->grabbedClasses[] = $fileName;
                }
            }
        }
    }

    /**
     * @return array
     */
    public function getFiles()
    {
        return $this->grabbedClasses;
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return array_key_exists($name, get_object_vars($this)) ?: $name;
    }

    /**
     * @param $name
     * @param $value
     *
     * @throws StubZeroException
     */
    public function __set($name, $value)
    {
        if (array_key_exists($name, get_object_vars($this)) === true) {
            $this->{$name} = $value;
        } else {
            throw new StubZeroException('Field ' . $name . ' not found into ' . self::class);
        }
    }
}
