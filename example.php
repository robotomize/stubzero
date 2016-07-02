<?php

use stubzero\Generator;
use test\data\User;

require __DIR__ . '/tests/data/User.php';
require __DIR__ . '/src/autoload.php';
require __DIR__ . '/vendor/autoload.php';

$complexObjectBasedLexical = Generator::generateSmart(User::class);
//
//$simpleObjectBasedTypes = Generator::createQuick(User::class);
//
//var_dump($simpleObjectBasedTypes);
var_dump($complexObjectBasedLexical);

//$crawl = new \stubzero\ClassCrawler('tests/data');
//
//$crawl->start();
//
//var_dump($crawl->getFiles());

Generator::code('tests/data');