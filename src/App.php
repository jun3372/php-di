<?php

namespace Jun3;

class App
{
    /**
     * 实例存储数组
     *
     * @var [type]
     */
    private static $instance = [];


    public static function container($instance)
    {
        if (!is_object($instance)) {
            $instance = new $instance();
        }

        // 获取Di容器类
        $di = self::getInstance(Di::class, function () {
            // 实例化Di容器类并存储
            return self::setInstance(Di::class, new Di());
        });


        // 获取类名
        $name = get_class($instance);
        if (!isset(self::$instance[$name])) {
            // 实例化容器
            $instance = $di->register($instance);

            // 存储类到容器
            return self::setInstance($name, $instance);
        }

        return self::getInstance($name);
    }

    /**
     * 设置实例
     *
     * @param string $name
     * @param [type] $instance
     * @return void
     */
    public static function setInstance($name, $instance)
    {
        // 存储容器实例
        self::$instance[$name] = $instance;

        // 返回存储的实例
        return self::getInstance($name);
    }

    /**
     * 获取实例
     *
     * @param string $name
     * @param [type] $def
     * @return void
     */
    public static function getInstance(string $name, $def = null)
    {
        if (isset(self::$instance[$name])) {
            return self::$instance[$name];
        }

        // 是否为闭包
        if ($def instanceof \Closure) {
            $def =  call_user_func($def);
        }

        return $def;
    }
}
