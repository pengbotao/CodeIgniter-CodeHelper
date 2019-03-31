<?php
/**
 * 模型生成器
 *
 */
class CH_Builder_Model extends CH_Builder_Abstract
{
    /**
     * 处理类
     * 
     * @param array $entities
     * @param string $model_name 模型类
     * @return boolean
     */
    public function handle($entities, $model_name = NULL)
    {
        $cnt = count($entities);
        if(! is_array($entities) || $cnt == 0) {
            return false;
        }
        if($cnt > 1) {
            $model_name = NULL;
        }
        foreach($entities as $entity) {
            $this->builder($entity, $model_name);
        }
        return true;
    }

    /**
     * 生成类
     * 
     * @param CH_Entity $Entity
     * @param string $model_name 模型名称
     * @return boolean
     */
    public function builder(CH_Entity $Entity, $model_name = NULL)
    {    
        $model_name = $this->getModelName($model_name, $Entity->table);
        $model_file_name = strtolower($model_name).'.php';
        $CH_Config = new CH_Config();
        $data = array(
                'entity' => $Entity,
                'model_name' => $model_name,
                'model_class_name' => $this->getModelClassName($model_name),
                'model_file_name' => $model_file_name,
        );
        $this->_handle('models/model', $CH_Config->getBuilderFile($model_file_name, 'model'), $data);
    }

    /**
     * 获取模型名称
     * 
     * @param string $model_name 用户输入模型名称
     * @param string $default 默认名称，即表名
     * @return string 生成后的模型名
     */
    public function getModelName($model_name, $default)
    {
        if(empty($model_name)) {
            $model_name = $default;
        }
        $model_name = ucfirst(strtolower($model_name)).'_model';
        return $model_name;
    }
    
    /**
     * 生成模型类名
     * @param string $model_name
     * @return string
     */
    public function getModelClassName($model_name) {
        if(strrpos($model_name, '/') !== false) {
            $model_name = ucfirst(substr($model_name, strrpos($model_name, '/') + 1));
        }
        return $model_name;
    }
}