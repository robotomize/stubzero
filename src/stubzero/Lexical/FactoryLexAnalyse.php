<?php

namespace stubzero\Lexical;

/**
 * Class FactoryLexAnalyse
 *
 * @package stubzero\Lexical
 * @author robotomzie@gmail.com
 */
class FactoryLexAnalyse
{
    /**
     * @param $value
     *
     * @return string
     */
    public static function run($value)
    {
        $model = new LexicalAnalyse();
        $model->setWord($value);
        $model->analyse();

        return $model->getResult();
    }
}