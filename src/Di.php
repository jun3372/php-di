<?php

namespace Jun3;

class Di
{
    /**
     * 实例存储变量
     *
     * @var [type]
     */
    private $instance;

    /**
     * 注册实例
     *
     * @param  [type] $instance
     * @return void
     */
    public function register($instance)
    {
        if (!is_object($instance)) {
            $instance = new $instance();
        }

        // 存储实例并返回当前对象
        return $this->setInstance($instance);
    }

    /**
     * 自动调用容器内的方法
     *
     * @param  string $method
     * @param  array  $parameters
     * @return void
     */
    public function __call(string $method, array $parameters)
    {
        $instance = $this->getInstance();
        if (!method_exists($instance, $method)) {
            $instance = get_class($instance);
            throw new \InvalidArgumentException("Instance [{$instance}] does not exist for [{$method}] method");
        }

        return $this->make($instance, $method, ...$parameters);
    }

    /**
     * 执行类的属性方法调用
     *
     * @param  [type] $instance
     * @param  [type] $method
     * @param  [type] ...$parameters
     * @return void
     */
    public function make($instance, $method, ...$parameters)
    {
        if (empty($instance)) {
            $instance = $this->getInstance();
        }

        // 建立一个类的反射类
        $reflector = new \ReflectionMethod($instance, $method);

        foreach ($reflector->getParameters() as $key => $parameter) {
            // 获取类
            $class = $parameter->getClass();
            if ($class) {
                // 获取参数
                $param = $parameters[$key] ?? null;

                // 判断参数是否为类的名称
                if (is_object($param) && get_class($param) == $class->name) {
                    continue;
                }

                // 替换参数
                array_splice($parameters, $key, 0, [new $class->name]);
            }
        }

        // 执行调用并返回
        return call_user_func_array([$instance, $method], $parameters);
    }

    /**
     * 设置实例
     *
     * @param  [type] $instance
     * @return void
     */
    public function setInstance($instance)
    {
        $this->instance = $instance;

        return $this;
    }

    /**
     * 获取实例
     *
     * @return void
     */
    public function getInstance()
    {
        return $this->instance;
    }
}
