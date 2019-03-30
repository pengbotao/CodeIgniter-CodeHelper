<?php
/**
 * 数据库实体加载类
 * 
 */
class CH_Loader_EntityLoader
{
    /**
     * 加载实体类，当前只有从数据库读取方式
     * 
     * @param mixed $param 参数
     * @param string $type 加载方式
     * @return array 返回CH_Entity对象数组
     */
    public static function load($param, $type = 'table')
    {
        switch ($type) {
            
            default:
                $entity = self::table($param);
        }
        return $entity;
    }

    /**
     * table方式加载
     * 
     * @param string $table_name
     * @return array 返回CH_Entity数组
     */
    public static function table($table_name)
    {
        $table_name = trim($table_name);
        if($table_name == '*' || empty($table_name)) {
            $table_name = NULL;
        }
        $LoaderEntity = new CH_Loader_Entity_Table();
        return $LoaderEntity->load($table_name);
    }
}