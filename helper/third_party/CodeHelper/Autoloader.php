<?php
/**
 * CodeHelper 根目录
 * @var string
 */
define('CH_PATH', str_replace("\\", "/", dirname(__FILE__)));

/**
 * CodeHelper 模版目录
 * @var string
 */
define('CH_TEMPLATE_PATH', CH_PATH.'/Template');

/**
 * CodeHelper自动加载类， 注册后会自动加载以CH_开头的类
 *
 */
class CH_Autoloader
{
    /**
     * 注册函数
     * 
     * @param string $prepend
     */
    public static function register($prepend = false)
    {
        if (version_compare(phpversion(), '5.3.0', '>=')) {
            spl_autoload_register(array(new self, 'autoload'), true, $prepend);
        } else {
            spl_autoload_register(array(new self, 'autoload'));
        }
    }

    /**
     * 自动加载方法
     * 
     * @param string $class 类名
     */
    public static function autoload($class)
    {
        if (0 !== strpos($class, 'CH_')) {
            return;
        }
        $class = substr($class, 3);
        $file = dirname(__FILE__).'/'.str_replace(array('_', "\0"), array('/', ''), $class).'.php';
        if (is_file($file)) {
            require $file;
        }
    }
}