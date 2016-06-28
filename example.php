<?php

use stubzero\Creator;
use stubzero\Generator;
use test\data\User;

require __DIR__ . '/tests/data/User.php';
require __DIR__ . '/src/autoload.php';
require __DIR__ . '/vendor/autoload.php';

$t = new Creator(User::class);
$t->start();