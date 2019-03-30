<?php
require_once APPPATH.'libraries/Twig.php';

/**
 * 模板类 用来读取需要生成的文件内容
 * 
 */
class CH_Template
{
    /**
     * Twig 模版对象
     * 
     * @var Object
     */
    public $view;

    public function __construct($view_path = NULL)
    {
        if(empty($view_path)) {
            $view_path = CH_TEMPLATE_PATH;
        }
        if(! file_exists($view_path)) {
            throw new CH_Exception('the template directory is not exists');
        }
        $this->view = new Twig(array('template_dir' => $view_path));
    }

    
    /**
     * 直接加载需要生成的模版文件
     * 
     * @param string $tpl 模版文件
     * @param array $data 渲染数组
     * @return string 渲染后的内容
     */
    public function load($tpl, $data)
    {
        return $this->view->render($tpl, $data, true);
    }

    /**
     * 渲染字符串
     * @param string $string 渲染字符串
     * @param array $data 渲染数组
     * @return string 返回渲染后的内容
     */
    public function loadString($string, $data)
    {
        return $this->view->parse($string, $data, true);
    }

    /**
     * 保存生成的文件
     * 
     * @param string|array $filename 文件名（含地址）
     * @param string $content 文件内容
     * @return boolean
     */
    public static function save($filename, $content)
    {
        if(! is_array($filename)) {
            $filename = array($filename);
        }
        $CH_Config = new CH_Config();
        foreach($filename as $val) {
            $folder = substr($val, 0, strrpos($val, '/'));
            if(! file_exists($folder)) {
                mkdir($folder, 0777, true);
            }
            $byte_count = @file_put_contents($val, $content);
            if($CH_Config->debug) {
                if($byte_count) {
                    echo realpath($val)." 成功<BR>";
                } else {
                    echo realpath($val)." 失败<BR>";
                }
            }
        }
        return true;
    }

    /**
     * 递归拷贝目录
     * 
     * @param string $folder_source 源目录
     * @param string $folder_dest 目标目录
     */
    public static function copyFolder($folder_source, $folder_dest)
    {
        if(substr($folder_source, -1) == '/') {
            $folder_source == substr($folder_source, 0, -1);
        }
        if(is_dir($folder_source)) {
            if(! file_exists($folder_dest)) {
                mkdir($folder_dest, 0777, true);
            }
            $dh = opendir($folder_source);
            if($dh) {
                while($file = readdir($dh)) {
                    if($file == '.' || $file == '..') {
                        continue;
                    } elseif(is_dir($folder_source.'/'.$file)) {
                        self::copyFolder($folder_source.'/'.$file, $folder_dest.'/'.$file);
                    } else {
                        self::copyFile($folder_source.'/'.$file, $folder_dest.'/'.$file);
                    }
                }
            }
        }
    }

    /**
     * 拷贝单个文件
     * 
     * @param string $file_source 源文件
     * @param string $file_dest 目标文件
     */
    public static function copyFile($file_source, $file_dest)
    {
        $file_folder = substr($file_dest, 0, strrpos($file_dest, '/'));
        if(! file_exists($file_folder)) {
            mkdir($file_folder, 0777, true);
        }
        @copy($file_source, $file_dest);
    }
    
    /**
     * 批量创建文件夹
     * 
     * @param string|array $folder
     */
    public static function createFolder($folder)
    {
        if(! is_array($folder)) {
            $folder = array($folder);
        }
        foreach($folder as $val) {
            if(! file_exists($val)) {
                mkdir($val, 0777, true);
            }
        }
    }
}