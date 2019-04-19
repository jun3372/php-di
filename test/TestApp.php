<?php

use Jun3\App;

require __DIR__ . '/../vendor/autoload.php';

class Test
{
    public function demo1($nane = 1)
    {
        var_dump($nane);
    }
}

// $instance = App::container(Test::class);

// $name = 122;
// $instance->demo1($name);


$di = di(Test::class);
var_dump($di);
