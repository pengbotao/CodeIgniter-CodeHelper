<?php
/**
 * 生成器抽象类
 * 
 */
abstract class CH_Builder_Abstract
{
    /**
     * 读取模版文件并写到到新的文件
     * 
     * @param string $template_name 模版文件名
     * @param string|array $builder_path 生成目录地址
     * @param array $data 模版渲染变量
     * @return boolean
     */
    protected function _handle($template_name, $builder_path, $data = array())
    {
        $Template = new CH_Template();
        $content = $Template->load($template_name, $data);
        return $Template->save($builder_path, $content);
    }
}