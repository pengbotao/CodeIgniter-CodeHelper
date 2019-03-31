<?php
/**
 * 权限管理
 *
 */
class CH_Module_Rbac extends CH_Builder_Abstract implements CH_Module_Interface
{
    /**
     * @see CH_Module_Interface::getModuleSwitch()
     */
    public function getModuleSwitch()
    {
        return false;
    }

    /**
     * @see CH_Module_Interface::getModuleName()
     */
    public function getModuleName()
    {
        return '权限管理';
    }

    /**
     * 权限管理路由地址
     */
    public function getModuleRoute()
    {
        return 'rbac';
    }

    /**
     * @see CH_Module_Interface::handle()
     */
    public function handle()
    {
        echo '权限管理开发中...<BR>';
    }
}