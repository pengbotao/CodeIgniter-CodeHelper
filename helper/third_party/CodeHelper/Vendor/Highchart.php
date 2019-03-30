<?php
/**
 * Hightchart图表模块
 * 
 */
class CH_Vendor_Highchart extends CH_Builder_Abstract implements CH_Vendor_Interface
{
    /**
     * 返回插件开关状态， false关闭 true打开
     * @see CH_Vendor_Interface::getVendorSwitch()
     */
    public function getVendorSwitch()
    {
        return true;
    }

    /**
     * @see CH_Vendor_Interface::getVendorName()
     */
    public function getVendorName()
    {
        return 'Highchart';
    }

    /**
     * @see CH_Vendor_Interface::handle()
     */
    public function handle()
    {
        $CH_Config = new CH_Config();
        CH_Template::copyFolder(CH_TEMPLATE_PATH.'/third_party/Highchart', $CH_Config->getInitFile('Highchart', 'third'));
    }
}