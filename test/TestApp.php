<?php

use Jun3\App;

require __DIR__ . '/../vendor/autoload.php';




if (!function_exists('dd')) {
    function dd(...$vars)
    {
        foreach ($vars as $key => $var) {
            if ($key > 0) {
                echo PHP_EOL;
            }

            if (is_array($var) || is_object($var)) {
                print_r($var);
                continue;
            }
            var_dump($var);
        }
        die;
    }
}


class A
{
    public function demo($a)
    {
        print_r($a);
    }
}

class B
{ }

class Test
{
    public $a;

    public function __construct(A $a, $c = 1, B $b, $d = 'd')
    {
        $this->a = $a;
        dd($a, $b, $c, $d, $this->a);
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
$b = di(B::class);
// print_r($a);
// die;
// $a = new A();

$di = di(Test::class, $a, 12, $b, 'd');
// $di->demo(1);
