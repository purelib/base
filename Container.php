<?php
namespace PureLib\Base;

class Container {

    protected $delegator;

    public function __construct ($delegator) {

        if (is_string($delegator)) {
            $delegator = new $delegator;
        }

        $this->delegator = $delegator;
    }

    public function getDelegator () {
        return $this->delegator;
    }

    public function __call($method, $args) {
        return call_user_func_array([$this->getDelegator(), $method], $args);
    }

    public static function getDefaultDelegator () {
      return '\Zend\ServiceManager\ServiceManager';
    }

    protected static $instances = [];

    public static function setInstance ($name, $container=null) {
        if ($container == null) {
            $container = new self(self::getDefaultDelegator());
        }

        self::$instances[$name] = $container;
    }

    public static function getInstance ($name='main') {
        if ($name === 'main' && !isset(self::$instances['main'])) {
            self::$instances['main'] = new self(self::getDefaultDelegator());
        }
        return self::$instances[$name];
    }
}