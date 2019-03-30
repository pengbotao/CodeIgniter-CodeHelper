<?php
/**
 * 缓存类
 * 
 */
class CH_Cache
{
    /**
     * 缓存文件夹名称
     * @var string
     */
    public static $cacheFolder = 'ch';

    /**
     * 获取缓存
     *
     * @param string $filename 缓存文件名
     * @return array
     */
    public static function getCache($filename)
    {
        $cache_folder = APPPATH.'cache/'.self::$cacheFolder;
        if(file_exists($cache_folder.'/'.$filename)) {
            $cache =  require $cache_folder.'/'.$filename;
        }
        if(! isset($cache) || ! is_array($cache)) {
            $cache = array();
        }
        return $cache;
    }

    /**
     * 设置缓存
     *
     * @param string $filename 文件名
     * @param array $data 缓存内容
     * @return int 返回写入字节数
     */
    public static function setCache($filename, $data)
    {
        $cache_folder = APPPATH.'cache/'.self::$cacheFolder;
        if(! file_exists($cache_folder)) {
            mkdir($cache_folder, 0777, true);
        }
        $file =$cache_folder.'/'.$filename;
        return file_put_contents($file, "<?php\r\n"."return ".var_export($data, true).";\r\n?>");
    }
}