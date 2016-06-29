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
     * @param $lex
     *
     * @return mixed
     */
    public function setWord($lex);

    /**
     * @return string
     */
    public function getResult();

    public function analyse();
}