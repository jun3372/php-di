<?php

if (!function_exists('di')) {
    /**
     * 获取容器实例
     *
     * @param [type] $instance
     * @return void
     */
    function di($instance)
    {
        return Jun3\App::container($instance);
    }
}

if (!function_exists('container')) {
    /**
     * 获取容器实例
     *
     * @param [type] $instance
     * @return void
     */
    function container($instance)
    {
        return Jun3\App::container($instance);
    }
}
