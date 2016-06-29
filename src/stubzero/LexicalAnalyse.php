<?php

namespace stubzero;


class LexicalAnalyse implements InterfaceLexicalAnalyse
{
    /**
     * @var string
     */
    private $result;

    public function analyse()
    {
        return false;
    }


    public function setWord($lex)
    {
        return false;
    }

    /**
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }
}