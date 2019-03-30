<?php
/**
 * 供货商接口
 *
 */
interface CH_Vendor_Interface
{
    /**
     * 返回插件开关状态， false关闭 true打开
     */
    public function getVendorSwitch();

    /**
     * 接口名称
     */
    public function getVendorName();
    
    /**
     * 生成代码
     */
    public function handle();
}