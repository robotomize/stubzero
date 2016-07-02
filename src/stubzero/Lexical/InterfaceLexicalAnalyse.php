<?php

namespace stubzero\Lexical;

/**
 * Interface InterfaceLexical
 *
 * @package stubzero\Lexical
 * @author robotomize@gmail.com
 */
interface InterfaceLexicalAnalyse
{
    /**
     * @param $word
     */
    public function setWord($word);

    /**
     * @return string
     */
    public function getResult();

    public function analyse();
}
