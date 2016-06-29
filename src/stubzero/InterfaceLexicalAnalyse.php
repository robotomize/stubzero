<?php

namespace stubzero;

/**
 * Interface InterfaceLexical
 *
 * @package stubzero
 * @author robotomize@gmail.com
 */
interface InterfaceLexicalAnalyse
{
    /**
     * @param array $tags
     * @return mixed
     */
    public function setWord($word);

    /**
     * @return string
     */
    public function getResult();

    public function analyse();
}