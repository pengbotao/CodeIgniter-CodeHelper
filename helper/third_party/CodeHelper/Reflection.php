<?php
/**
 * 反射类
 * 
 */
class CH_Reflection
{
    /**
     * 根据目录和方式获取所有类
     * 
     * @param string $class_name 继承或者实现的接口名称
     * @param string $folder 目录名称
     * @param number $reflection_type 反射方式
     * @return multitype:ReflectionClass
     */
    public static function load($class_name, $folder, $reflection_type = 1)
    {
        self::loadFiles($folder);
        $reflection_class = array();
        foreach(get_declared_classes() as $class) {
            $ReflectionClass = new ReflectionClass($class);
            $reflection_method = self::getReflectionMethod($reflection_type);
            if($ReflectionClass->$reflection_method($class_name)) {
                $reflection_class[md5($ReflectionClass->getName())] = $ReflectionClass;
            }
        }
        return $reflection_class;
    }

    /**
     * 加载文件夹下所有文件
     * @param string $folder
     */
    public static function loadFiles($folder)
    {
        if(is_dir($folder)) {
            $dh = opendir($folder);
            while($file = readdir($dh)) {
                if($file == '.' || $file == '..') {
                    continue;
                } elseif(is_dir($folder.'/'.$file)) {
                    self::loadFiles($folder.'/'.$file);
                } else {
                    if(strtolower(pathinfo($file, PATHINFO_EXTENSION)) != 'php') {
                        continue;
                    }
                    require_once $folder.'/'.$file;
                }
            }
        }
    }

    /**
     * 获取反射方法， 默认为实现接口
     * 
     * @param number $reflection_type
     * @return string
     */
    public static function getReflectionMethod($reflection_type =1) {
        switch($reflection_type) {
            default:
                $method = 'implementsInterface';
        }
        return $method;
    }
}