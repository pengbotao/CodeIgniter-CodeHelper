<?php
/**
 * 模块化接口
 *
 */
interface CH_Module_Interface
{
    /**
     * 返回插件开关， false关闭模块 true打开模块
     */
    public function getModuleSwitch();
    
    /**
     * 获取模块名称
     */
    public function getModuleName();
    
    /**
     * 生成代码
     */
    public function handle();
}