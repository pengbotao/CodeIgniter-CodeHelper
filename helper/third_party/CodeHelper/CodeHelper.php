<?php
/**
 * CodeHelper 类
 *
 */
class CH_CodeHelper
{
    /**
     * 生成模型
     * 
     * @param string $table_name 表名
     * @param string $model_name 模型名
     * @throws CH_Exception 未找到表名则抛出异常
     * @return boolean true生成成功 false生成失败
     */
    public function model($table_name, $model_name = '')
    {
        $Builder = new CH_Builder_Model();
        $entities = CH_Loader_EntityLoader::load($table_name);
        if(empty($entities)) {
            throw new CH_Exception('读取表结构失败，请检测数据库配置文件。');
        }
        return $Builder->handle($entities, $model_name);
    }

    /**
     * 生成控制器
     * 
     * @param string $table_name 表名
     * @param string $controller_name 控制器名
     * @param string $model_name 模型名
     * @throws CH_Exception 未找到表名则抛出异常
     * @return boolean true生成成功 false生成失败
     */
    public function controller($table_name, $controller_name = '', $model_name = '')
    {
        $Builder = new CH_Builder_Controller();
        $entities = CH_Loader_EntityLoader::load($table_name);
        if(empty($entities)) {
            throw new CH_Exception('读取表结构失败，请检测数据库配置文件。');
        }
        return $Builder->handle($entities, $controller_name, $model_name);
    }

    /**
     * 生成插件
     */
    public function module()
    {
        $CH_Config = new CH_Config();
        $CH_Module_Manager = new CH_Module_Manager();
        $CH_Module_Manager->handle($CH_Config->getProjectModule());
    }

    /**
     * 生成类库
     */
    public function vendor()
    {
        $CH_Config = new CH_Config();
        $CH_Vendor_Manager = new CH_Vendor_Manager();
        $CH_Vendor_Manager->handle($CH_Config->getProjectVendor());
    }

    /**
     * 初始化
     */
    public function initialize()
    {
        $CH_Builder_Initialize = new CH_Builder_Initialize();
        $CH_Builder_Initialize->handle();
    }

    /**
     * 项目检测
     *
     * @return array
     */
    public function detection()
    {
        $CH_Detection = new CH_Detection();
        $CH_Detection->handle();
        return $CH_Detection->getErrorMessage();
    }

    /**
     * 获取模块列表
     * 
     * @return array
     */
    public function getModuleList()
    {
        $CH_Module_Manager = new CH_Module_Manager();
        return $CH_Module_Manager->getModuleList();
    }

    /**
     * 获取类库列表
     * 
     * @return array
     */
    public function getVendorList()
    {
        $CH_Vendor_Manager = new CH_Vendor_Manager();
        return $CH_Vendor_Manager->getVendorList();
    }
}