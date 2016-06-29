<?php

namespace stubzero;

/**
 * Class LexicalAnalyse
 * @package stubzero
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
     * @param array $r
     * @param $q
     * @return bool
     */
    public static function search($r, $q)
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

    public function analyse()
    {
        foreach (LexicalDispenser::$fakerDispenserMap as $token => $fakerMethod) {
            if (self::search($token, $this->word) === true) {
                return $fakerMethod;
            }
        }
        return false;
    }

    /**
     * @param array $tags
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
}