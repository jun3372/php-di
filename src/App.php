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


    /**
     * 处理容器
     *
     * @param  string $instance
     * @param  array  ...$parameters
     * @return void
     */
    public static function container($instance, ...$parameters)
    {
        if (!is_object($instance)) {
            // 实例化一个反射类
            $class = new \ReflectionClass($instance);
            // 创建一个新的类实例而不调用它的构造函数
            $instance = $class->newInstanceWithoutConstructor();

            // 获取构造函数
            $constructor = $class->getConstructor();
            // 是否存在构造函数
            if ($constructor) {
                // 获取参数列表
                $parameters = App::getConstructorParameters($constructor, $parameters);
                //执行构造函数的方法注入
                $constructor->invokeArgs($instance, $parameters);
            }
        }

        // 获取Di容器类
        $di = self::getInstance(
            Di::class,
            function () {
                // 实例化Di容器类并存储
                return self::setInstance(Di::class, new Di());
            }
        );

        // 克隆di容器对象
        $di = clone $di;

        // 获取容器类名
        $name = get_class($instance);
        // 判断是否已经存在容器类
        if (!isset(self::$instance[$name])) {
            // 实例化容器
            $instance = $di->register($instance);

            // 存储类到容器
            return self::setInstance($name, $instance)->getInstance();
        }

        // 获取已经存在的容器类
        return self::getInstance($name)->getInstance();
    }

    /**
     * 获取构造函数的参数列表
     *
     * @param  [type] $reflect
     * @param  array  $parameters
     * @param  array  $avgs
     * @return array
     */
    public static function getConstructorParameters($reflect, array $parameters, array $avgs = []): array
    {
        // 是否需要处理参数
        if (count($parameters) > 0) {
            // 获取所有已经存在容器
            $instance = App::getInstance();
            // 循环处理是否需要实例化的参数
            foreach ($parameters as &$item) {
                // 是否已经为对象
                if (is_object($item)) {
                    continue;
                }

                // 是否已经存在该容器
                if (isset($instance[$item])) {
                    $item = $instance[$item]->getInstance();
                    continue;
                }

                // 是否需要实例化容器
                if (class_exists($item)) {
                    $item = App::container($item);
                    continue;
                }
            }
        }

        if ($reflect->getNumberOfParameters() > 0) {
            $i = 0;
            foreach ($reflect->getParameters() as $key => $param) {
                $type  = $param->getClass(); //获取当前注入对象的类型提示
                if ($type) {
                    // 获取容器类名名称
                    $name = $type->getName();
                    // 获取容器
                    $instance = App::getInstance($name)->getInstance();
                    if ($parameters[$i] === $instance) {
                        $i++;
                    }

                    // 获取容器
                    $avgs[] = $instance ??  $parameters[$i];
                    continue;
                }

                // 设置默认值
                $avgs[] = $parameters[$i] ?? null;
                $i++;
            }
        }

        return $avgs;
    }

    /**
     * 设置实例
     *
     * @param  string $name
     * @param  [type] $instance
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
     * @param  string $name
     * @param  [type] $def
     * @return void
     */
    public static function getInstance(string $name = '', $def = null)
    {
        if (empty($name)) {
            return self::$instance;
        }

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
