<?php

use Jun3\App;

require __DIR__ . '/../vendor/autoload.php';

class A
{
    public function demo($a)
    {
        print_r($a);
    }
}

class B
{
}

class Test
{
    public $a;

    public function __construct(A $a, B $b, $c = 1)
    {
        $this->a = $a;
        var_dump($c);
    }

    public function demo($nane = 1)
    {
        $this->a->demo($nane);
        // var_dump();
        // var_dump($nane);
    }
}

// $instance = App::container(Test::class);

// $name = 122;
// $instance->demo1($name);

$a = di(A::class);
$a = di(B::class);
// print_r($a);
// die;
// $a = new A();

$di = di(Test::class, $a, B::class, '12');
$di->demo(1);
