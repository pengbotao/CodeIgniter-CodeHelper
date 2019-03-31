<?php
/**
 * 运行类，记录日志，获取已生成菜单
 * 
 */
class CH_Runtime
{
    /**
     * 已生成控制器缓存文件
     * @var string
     */
    public static $controllerFile = 'Controller.php'; 

    /**
     * 项目配置文件
     * @var string
     */
    public static $projectFile = 'Project.php';

    /**
     * 记录已生成控制器
     * 
     * @param CH_Entity $Entity
     * @param string $controller_name
     * @param string $model_name
     * @return int 写入字节数
     */
    public static function logController(CH_Entity $Entity, $controller_name, $model_name)
    {
        $cache = CH_Cache::getCache(self::$controllerFile);
        $cache[strtolower($Entity->database)][strtolower($Entity->table)] = array(
                'menu_name' => $Entity->comment,
                'controller_name' => strtolower($controller_name),
                'model_name' => $model_name,
                'created_ts' => date("Y-m-d H:i:s"),
        );

        $CH_Config = new CH_Config();
        $project_path = $CH_Config->getProjectPath();
        foreach($cache as $db => $tables) {
            if(empty($tables)) {
                unset($cache[$db]);
            }
            foreach($tables as $table => $val) {
                if(! file_exists($project_path.'/controllers/'.$val['controller_name'].'.php')) {
                    unset($cache[$db][$table]);
                }
            }
        }
        return CH_Cache::setCache(self::$controllerFile, $cache);
    }

    /**
     * 获取已生成控制器菜单
     * 
     * @return array
     */
    public static function menu()
    {        
        if ( ! defined('ENVIRONMENT') OR ! file_exists($file_path = APPPATH.'config/'.ENVIRONMENT.'/database.php'))    {
            if ( ! file_exists($file_path = APPPATH.'config/database.php'))    {
                return array();
            }
        }

        include($file_path);

        if(! isset($active_group) || ! isset($db[$active_group])) {
            return array();
        }

        $dbname = $db[$active_group]['database'];
        $result = array();

        $cache = CH_Cache::getCache(self::$controllerFile);
        $CH_Config = new CH_Config();
        $project_path = $CH_Config->getProjectPath();
        
        if(is_array($cache)) {
            foreach($cache as $db => $tables) {
                if($db != $dbname) {
                    continue;
                }
                foreach($tables as $table => $val) {
                    if(file_exists($project_path.'/controllers/'.$val['controller_name'].'.php')) {
                        $result[$db][$val['controller_name']] = $val['menu_name'];
                    } else {
                        unset($cache[$db][$table]);
                    }
                }
            }
            CH_Cache::setCache(self::$controllerFile, $cache);
        }
        return $result;
    }

    /**
     * 切换Application地址后重新设置项目
     *
     * @return string
     */
    private static function getUniqueId()
    {
        return md5(realpath(APPPATH));
    }

    /**
     * 设置配置
     * 
     * @param array $data
     * @return number
     */
    public static function setProject($data)
    {
        $data['unique_id'] = self::getUniqueId();
        return CH_Cache::setCache(self::$projectFile, $data);
    }

    /**
     * 获取配置
     * 
     * @return array
     */
    public static function getProject()
    {
        $cache = CH_Cache::getCache(self::$projectFile);
        if(!is_array($cache) || count($cache) == 0) {
            return array();
        }
        if(! isset($cache['unique_id']) || self::getUniqueId() != $cache['unique_id']) {
            return array();
        }
        return $cache;
    }
}