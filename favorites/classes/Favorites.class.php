<?php
class Favorites{
    private $_plugins = array();

    function __construct(){
        include_once "IPlugin.class.php";
        foreach (glob('classes/*/*.class.php') as $file){
            include "$file";
        }
        $this->findPlugins();
    }

    private function findPlugins() {
        foreach (get_declared_classes() as $class){
            $interfaces = class_implements($class);
            if(isset($interfaces['IPlugin'])){
                 $this->_plugins[] = new ReflectionClass($class);
            }
        }
        //print_r($this->_plugins);
    }

    function getFavorites($methodName) {
        $list = array();
        foreach($this->_plugins as $plugin){
            if($plugin->hasMethod($methodName)){
                $reflectionMethod = $plugin->getMethod($methodName);
                if($reflectionMethod->isStatic()){
                    //echo "<pre>";
                    //print_r($reflectionMethod->invoke(null));

                    $list = array_merge($list, $reflectionMethod->invoke(null));
                }else{
                    $instance = $plugin->newInstance();
                    $list = array_merge($list, $reflectionMethod->invoke($instance));
                }
            }
        }
        return $list;
    }
}