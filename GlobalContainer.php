<?php
namespace PureLib\Base;

class GlobalContainer {
    protected static $container;
    public static function ready ($config=null) {
        $container = new Container($config);
        self::$container = $container;
        return self::$container;
    }

    public static function __callStatic ($method, $args) {
        return call_user_func_array([self::$container, $method], $args);
    }

    public static function setValue ($name, $value) {
        self::$container->setService($name, $value);
        return self::$container;
    }
}