<?php

namespace Jun3;

use Jun3\App;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/A.php';
require __DIR__ . '/B.php';


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

class Test
{
    public $a;

    public function __construct(A $a, B $b, $c = 1, $d = 'd')
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

$di = di(Test::class, $a, $b, 12, 'd');
// $di->demo(1);
