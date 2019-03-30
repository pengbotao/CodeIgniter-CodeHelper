<?php
/**
 * 类库管理器
 *
 */
class CH_Vendor_Manager
{
    /**
     * 所有类库
     * @var array
     */
    public $vendor = array();
    
    /**
     * 初始化插件列表
     */
    public function __construct()
    {
        $this->vendor = CH_Reflection::load('CH_Vendor_Interface', CH_PATH.'/Vendor');
    }
    
    /**
     * 生成代码
     * @param sting|array $vendor_name md5后的类名
     */
    public function handle($vendor_name)
    {
        if(! is_array($vendor_name)) {
            $vendor_name = array($vendor_name);
        }
        foreach($vendor_name as $val) {
            if(isset($this->vendor[$val])) {
                $vendor = $this->vendor[$val];
                $reflection_method = $vendor->getMethod('handle');
                $reflection_method->invoke($vendor->newInstance());
            }
        }
    }

    /**
     * 获取所有可生成类库列表
     */
    public function getVendorList()
    {
        $vendor_list = array();
        foreach($this->vendor as $md5_class_name => $vendor) {
            $vendor_instance = $vendor->newInstance();
            $reflection_switch = $vendor->getMethod('getVendorSwitch');
            if(! $reflection_switch->invoke($vendor_instance)) {
                continue;
            }
            $reflection_name = $vendor->getMethod('getVendorName');
            $vendor_list[$md5_class_name] = $reflection_name->invoke($vendor_instance);
        }
        return $vendor_list;
    }
}
