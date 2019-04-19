# 简单的Di容器依赖注入管理

### 安装
    composer require jun3/di

### 声明类

```php
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

    public function __construct(A $a, $c = 1, B $b, $d = 'd')
    {
        $this->a = $a;
        dd($a, $b, $c, $d, $this->a);
    }

    public function demo($nane = 1)
    {
        $this->a->demo($nane);
    }
}
```

### 参数说明
```php
di(类名, 构造函数参数多个以逗号链接...)->类的函数名称(参数...)
```

### 静态类调用
```php
$instance = App::container(Test::class, $a, 12, $b, 'd')->demo();
```

### 助手函数滴啊用
```php
di(Test::class, $a, 12, $b, 'd')->demo();
或
container(Test::class, $a, 12, $b, 'd')->demo();
```

