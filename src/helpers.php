<?php

if (!function_exists('di')) {
    /**
     * 获取容器实例
     *
     * @param [type] $instance
     * @return void
     */
    function di($instance, ...$parameters)
    {
        return Jun3\App::container($instance, ...$parameters);
    }
}

if (!function_exists('container')) {
    /**
     * 获取容器实例
     *
     * @param [type] $instance
     * @return void
     */
    function container($instance, ...$parameters)
    {
        return Jun3\App::container($instance, ...$parameters);
    }
}


function dd(...$vars)
{
    foreach ($vars as $key => $var) {
        if ($key > 0){
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
