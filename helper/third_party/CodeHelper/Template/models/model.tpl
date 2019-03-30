<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * {{ entity.comment }}模型
 * 
 */
class {{ model_class_name }} Extends MY_Model
{
    /**
     * 主键
     */
    public function primaryKey()
    {
        return '{{ entity.primaryKey }}';
    }

    /**
     * 表名称
     */
    public function tableName()
    {
        return '{{ entity.table }}';
    }

    /**
     * 字段
     */
    public function attributes()
    {
        return array(
{% for key, val in entity.field %}
            '{{ val }}' => '{{ entity.fieldAlias[key] }}',
{% endfor %}
        );
    }
}

/* End of file {{ model_file_name }} */
/* Location: ./application/models/{{ model_file_name }} */