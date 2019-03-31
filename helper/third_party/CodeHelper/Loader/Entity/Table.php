<?php
/**
 * 从数据库中加载表结构
 * 
 */
class CH_Loader_Entity_Table
{
    /**
     * CI超级对象
     * @var object
     */
    public $CodeIgniter;

    public function __construct()
    {
        $this->CodeIgniter = & get_instance();
    }

    /**
     * 通过数据库加载表结构信息
     * 
     * @param string $table_name
     */
    public function load($table_name = NULL)
    {
        $columns = $this->getColumnInfo($table_name);
        $result = array();
        foreach($columns as $val) {
            $Entity = new CH_Entity();
            
            $Entity->database = $val['database'];
            $Entity->field = $val['field'];
            $Entity->fieldAlias = $val['field_alias'];
            $Entity->table = $val['table_name'];
            $Entity->primaryKey = isset($val['primary_key']) ? $val['primary_key'] : NULL;
            
            $table_info = $this->getTableInfo($Entity->table);
            $Entity->engine = $table_info[$Entity->table]['engine'];
            $Entity->comment = $this->getAliasComment($table_info[$Entity->table]['comment'], $Entity->table);
            $Entity->fieldDefine = $val['field_define'];
            if(empty($Entity->primaryKey)) {
                continue;
            }
            $result[] = $Entity;
        }
        return $result;
    }

    /**
     * 获取字段别名，字段注释以 | 分隔
     * 
     * @param string $comment
     * @return 返回处理过的字段别名
     */
    public function getAliasTitle($comment)
    {
        if(($pos = strpos($comment, '|')) !== false) {
            $comment = substr($comment, 0, $pos);
        }
        $comment = mb_substr($comment, 0, 10, 'utf-8');
        return $comment;
    }

    /**
     * 获取表评论
     * 
     * @param string $comment
     * @param string $default
     * @return string 处理过的别名
     */
    public function getAliasComment($comment, $default)
    {
        $alias = $this->getAliasTitle($comment);
        if(strpos($alias, 'InnoDB') !== false || empty($alias)) {
            $alias = $default;
        }
        return $alias;
    }

    /**
     * 获取表字段信息
     * 
     * @param string $table_name表名，为空则读取所有表
     * @return array 未读取到表信息则返回空数组
     */
    public function getColumnInfo($table_name = NULL)
    {
        $this->CodeIgniter->load->database();
        $dbname = $this->CodeIgniter->db->database;
        $sql  = "SELECT * ";
        $sql .= "FROM information_schema.columns ";
        $sql .= "WHERE TABLE_SCHEMA = '".$dbname."' ";
        if($table_name !== NULL) {
            $sql .= "AND TABLE_NAME = '".$table_name."' ";
        }
        $sql .= "ORDER BY TABLE_NAME, ORDINAL_POSITION ASC ";
        $query = $this->CodeIgniter->db->query($sql);
        $result = array();
        if($query->num_rows() > 0) {
            $result = array();
            foreach($query->result() as $row) {
                $result[$row->TABLE_NAME]['database'] = $dbname;
                $result[$row->TABLE_NAME]['table_name'] = $row->TABLE_NAME;
                if($row->COLUMN_KEY == 'PRI') {
                    $result[$row->TABLE_NAME]['primary_key'] = $row->COLUMN_NAME;
                }
                $result[$row->TABLE_NAME]['field'][] = $row->COLUMN_NAME;
                $field_alias = empty($row->COLUMN_COMMENT) ? $row->COLUMN_NAME : $this->getAliasTitle($row->COLUMN_COMMENT);
                $result[$row->TABLE_NAME]['field_alias'][] = $field_alias;
                $result[$row->TABLE_NAME]['field_define'][$row->COLUMN_NAME] = array(
                    'required' => $row->IS_NULLABLE == 'YES' ? false : true,
                    'data_type' => $row->DATA_TYPE,
                    'column_type' => $row->COLUMN_TYPE,
                    'column_default' => $row->COLUMN_DEFAULT,
                    'character_maximum_length' => $row->CHARACTER_MAXIMUM_LENGTH,
                    'character_octet_length' => $row->CHARACTER_OCTET_LENGTH,
                    'numeric_precision' => $row->NUMERIC_PRECISION,
                    'numeric_scale' => $row->NUMERIC_SCALE,
                    'alias' => $field_alias,
                );
            }
        }
        return $result;
    }

    /**
     * 根据表名获取表信息（引擎、表注释等）
     * 
     * @param string $table_name 表名，为空则读取所有表
     * @return array 未读取到表信息则返回空数组
     */
    public function getTableInfo($table_name = NULL)
    {
        $this->CodeIgniter->load->database();
        $dbname = $this->CodeIgniter->db->database;
        $sql  = "SELECT * ";
        $sql .= "FROM information_schema.TABLES ";
        $sql .= "WHERE TABLE_SCHEMA = '".$dbname."' ";
        if($table_name !== NULL) {
            $sql .= "AND TABLE_NAME = '".$table_name."' ";
        }
        $query = $this->CodeIgniter->db->query($sql);
        $result = array();
        if($query->num_rows() > 0) {
            foreach($query->result() as $row) {
                $result[$row->TABLE_NAME] = array(
                    'table_name' => $row->TABLE_NAME,
                    'comment' => $row->TABLE_COMMENT,
                    'engine' => $row->ENGINE,
                );
            }
        }
        return $result;
    }
}