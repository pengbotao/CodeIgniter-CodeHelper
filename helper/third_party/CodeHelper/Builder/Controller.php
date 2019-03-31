<?php
/**
 * 控制器生成器
 * 
 */
class CH_Builder_Controller extends CH_Builder_Abstract
{
    /**
     * 处理类
     * 
     * @param array $entities
     * @param string $controller_name 控制器名称
     * @param string $model_name 模型名称
     * @return boolean
     */
    public function handle($entities, $controller_name = NULL, $model_name = NULL)
    {
        $cnt = count($entities);
        if(! is_array($entities) || $cnt == 0) {
            return false;
        }
        if($cnt > 1) {
            $controller_name = NULL;
            $model_name = NULL;
        }
        foreach($entities as $entity) {
            $this->builder($entity, $controller_name, $model_name);
        }
        $CH_Builder_Update = new CH_Builder_Update();
        $CH_Builder_Update->update();
        return true;
    }

    /**
     * 生成类
     * 
     * @param CH_Entity $Entity
     * @param string $controller_name 控制器名称
     * @param string $model_name 模型名称
     * @return boolean
     */
    public function builder(CH_Entity $Entity, $controller_name = NULL, $model_name = NULL, $log = true)
    {
        $controller_name = $this->getControllerName($controller_name, $Entity->table);
        $controller_file_name = strtolower($controller_name).'.php';
        $CH_Builder_Model = new CH_Builder_Model();
        $model_name = strtolower($CH_Builder_Model->getModelName($model_name, $Entity->table));
        $model_class_name = strtolower($CH_Builder_Model->getModelClassName($model_name));
        $CH_Config = new CH_Config();
        if($CH_Config->getTplType() == 'php') {
            $render = '$this->load->view';
        } else {
            $render = '$this->view->render';
        }
        // @todo 对于验证规则的使用当前只判断了为空
        $form_rules = array();
        foreach($Entity->fieldDefine as $key => $val) {
            if($key != $Entity->primaryKey && $val['required']) {
                $form_rules[$key] = $val;
            }
        }
        $data = array(
                'entity' => $Entity,
                'form_rules' => $form_rules,
                'model_name' => $model_name,
                'model_class_name' => $model_class_name,
                'controller_name' => $controller_name,
                'controller_file_name' => $controller_file_name,
                'controller_class_name' => $this->getControllerClassName($controller_name),
                'view_folder' => strtolower($controller_name),
                'render' => $render,
        );
        if($this->_handle('controllers/controller', $CH_Config->getBuilderFile($controller_file_name, 'controller'), $data)) {
            if($log) {
                CH_Runtime::logController($Entity, $controller_name, $model_name);
            }

            $CH_Builder_View = new CH_Builder_View();
            $CH_Builder_View->handle($Entity, $controller_name);
        }
    }

    /**
     * 获取控制器名称
     * 
     * @param string $controller_name 用户输入的 控制器名称
     * @param string $default 默认名称 - 表名
     * @return string 生成后的控制器名称
     */
    public function getControllerName($controller_name, $default)
    {
        if(empty($controller_name)) {
            $controller_name = $default;
        }
        $controller_name = ucfirst(strtolower($controller_name));
        return $controller_name;
    }

    /**
     * 获取控制器类名，支持文件夹
     * @param string $controller_name
     * @return string 控制器
     */
    public function getControllerClassName($controller_name)
    {
        if(strrpos($controller_name, '/') !== false) {
            $controller_name = ucfirst(substr($controller_name, strrpos($controller_name, '/') + 1));
        }
        return $controller_name;
    }
}