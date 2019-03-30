<?php
/**
 * 数据库实体类
 * 
 */
class CH_Entity
{
    /**
     * 数据库
     * 
     * @var string
     */
    public $database;

    /**
     * 表名
     * 
     * @var string
     */
    public $table;
    
    /**
     * 引擎
     * 
     * @var string
     */
    public $engine;
    
    /**
     * 主键名
     * 
     * @var string
     */
    public $primaryKey;
    
    /**
     * 表注释
     * 
     * @var string
     */
    public $comment;
    
    /**
     * 字段列表
     * 
     * @var array
     */
    public $field = array();
    
    /**
     * 字段别名
     * 
     * @var array
     */
    public $fieldAlias = array();
    
    /**
     * 字段校验规则
     * 
     * @var array
     */
    public $fieldDefine = array();
    
}