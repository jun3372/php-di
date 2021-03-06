<?php

if (!function_exists('di')) {
    /**
     * 获取容器实例
     *
     * @param  [type] $instance
     * @return mixed
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
     * @param  [type] $instance
     * @return mixed
     */
    function container($instance, ...$parameters)
    {
        return Jun3\App::container($instance, ...$parameters);
    }
}
