<?php
/**
 * 插件管理器
 *
 */
class CH_Module_Manager
{
    /**
     * 所有插件
     * @var array
     */
    public $module = array();
    
    /**
     * 初始化插件列表
     */
    public function __construct()
    {
        $this->module = CH_Reflection::load('CH_Module_Interface', CH_PATH.'/Module');
    }
    
    /**
     * 生成代码
     * @param sting|array $module_name md5后的类名
     */
    public function handle($module_name)
    {
        if(! is_array($module_name)) {
            $module_name = array($module_name);
        }
        foreach($module_name as $val) {
            if(isset($this->module[$val])) {
                $module = $this->module[$val];
                $reflection_method = $module->getMethod('handle');
                $reflection_method->invoke($module->newInstance());
            }
        }
    }
    
    /**
     * 获取插件菜单
     * @param string|array $module_name
     * @return array
     */
    public function getModuleMenu($module_name)
    {
        $menu = array();
        if(! is_array($module_name)) {
            $module_name = array($module_name);
        }
        foreach($module_name as $val) {
            if(isset($this->module[$val])) {
                $module = $this->module[$val];
                if(! $module->hasMethod('getModuleRoute')) {
                    continue;
                }
                $module_instance = $module->newInstance();
                $reflection_route = $module->getMethod('getModuleRoute');
                $reflection_name = $module->getMethod('getModuleName');
                $menu[] = array(
                    'title' => $reflection_name->invoke($module_instance),
                    'route' => $reflection_route->invoke($module_instance),
                );
            }
        }
        return $menu;
    }
    
    /**
     * 根据方法获取返回内容，并将返回内容连接在一起后返回
     * @param string|array $module_name
     * @param string $method
     * @return string
     */
    public function getContentByMethod($module_name, $method)
    {
        $update_string = NULL;
        if(! is_array($module_name)) {
            $module_name = array($module_name);
        }
        foreach($module_name as $val) {
            if(isset($this->module[$val])) {
                $module = $this->module[$val];
                if(! $module->hasMethod($method)) {
                    continue;
                }
                $module_instance = $module->newInstance();
                $reflection_method = $module->getMethod($method);
                $update_string .= $reflection_method->invoke($module_instance);
            }
        }
        return $update_string;
    }

    /**
     * 根据插件开关获取插件
     * @return array
     */
    public function getModuleList()
    {
        $module_list = array();
        foreach($this->module as $md5_class_name => $module) {
            $module_instance = $module->newInstance();
            $reflection_flag = $module->getMethod('getModuleSwitch');
            if(! $reflection_flag->invoke($module_instance)) {
                continue;
            }
            $reflection_name = $module->getMethod('getModuleName');
            $module_list[$md5_class_name] = $reflection_name->invoke($module_instance);
        }
        return $module_list;
    }
}
