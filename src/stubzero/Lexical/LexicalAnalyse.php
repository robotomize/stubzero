<?php

namespace stubzero\Lexical;

/**
 * Class LexicalAnalyse
 * @package stubzero\Lexical
 * @author robotomize@gmail.com
 */
class LexicalAnalyse implements InterfaceLexicalAnalyse
{
    /**
     * @var string
     */
    private $result;

    /**
     * @var string
     */
    private $word;

    /**
     * @return null
     */
    public function analyse()
    {
        foreach (LexicalDispenser::$fakerLexicalDispenserMap as $token => $fakerMethod) {
            if (self::search($token, $this->word) === true) {
                $this->result = $fakerMethod;
            }
        }
    }

    /**
     * @param $word
     */
    public function setWord($word)
    {
        $this->word = $word;
    }


    /**
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param $stringPattern
     *
     * @return float
     */
    private static function generateAccuracy($stringPattern)
    {
        return round(mb_strlen($stringPattern) / 2) - 1;
    }

    /**
     * @param $o
     * @param $t
     *
     * @return int
     */
    private static function calc($o, $t)
    {
        return levenshtein($o, $t);
    }

    /**
     * @param $r
     * @param $q
     *
     * @return bool
     */
    private static function search($r, $q)
    {
        $result = false;

        if (mb_strlen($q) < mb_strlen($r)) {
            $r = mb_substr($r, 0, mb_strlen($q));
        } else {
            $q = mb_substr($q, 0, mb_strlen($r));
        }

        $distance = self::calc(mb_strtolower($q), mb_strtolower($r));

        if (self::generateAccuracy($r) >= $distance) {
            $result = true;
        }

        return $result;
    }
}
