<?php
/**
 * 项目初始化检测
 * 
 */
class CH_Detection
{
    /**
     * 错误信息
     * @var array
     */
    public $errorMessage = array();

    /**
     * 正确信息
     * @var array
     */
    public $successMessage = array();

    /**
     * 检测数据库基于文件权限
     */
    public function handle()
    {
        $this->isConnect();
    }

    /**
     * 目录是否可写
     * 
     * @param string $folder
     * @return CH_Detection
     */
    public function isWriteable($folder)
    {
        if(! is_array($folder)) {
            $folder = array($folder);
        }
        foreach($folder as $val) {
            if(is_really_writable($val)) {
                $this->setErrorMessage('目录不可写 '.$val);
            } else {
                $this->setSuccessMessage($val.' 正常');
            }
        }
        return $this;
    }

    /**
     * 目录是否存在
     * @param string $folder
     * @return CH_Detection
     */
    public function isExists($folder) {
        if(! is_array($folder)) {
            $folder = array($folder);
        }
        foreach($folder as $val) {
            if(! file_exists($val)) {
                $this->setErrorMessage('文件或目录不存在 '.$val);
            } else {
                $this->setSuccessMessage($val.' 正常');
            }
        }
        return $this;
    }

    /**
     * 数据库配置是否正常
     * @return CH_Detection
     */
    public function isConnect()
    {
        if (! defined('ENVIRONMENT') OR ! file_exists($file_path = APPPATH.'config/'.ENVIRONMENT.'/database.php'))    {
            if (! file_exists($file_path = APPPATH.'config/database.php'))    {
                $file_path = false;
            }
        }
        if($file_path == false) {
            $this->setErrorMessage('读取数据库配置文件失败 '.$file_path);
            return $this;
        }
        include($file_path);
        if(! isset($active_group) || ! isset($db[$active_group])) {
            $this->setErrorMessage('数据库配置无激活连接 '.$file_path);
            return $this;
        }
        
        if(empty($db[$active_group]['hostname']) || empty($db[$active_group]['username'])) {
            $this->setErrorMessage('请配置数据库链接 '.$file_path);
            return $this;
        }
        $ci = & get_instance();
        $ci->load->database();
        if($ci->db->conn_id === false) {
            $this->setErrorMessage('数据库链接失败，请配置数据库链接 '.$file_path);
        }
        return $this;
    }

    /**
     * 设置错误信息
     * 
     * @param string $msg
     * @return CH_Detection
     */
    public function setErrorMessage($msg)
    {
        $this->errorMessage[] = $msg;
        return $this;
    }

    /**
     * 设置成功信息
     * 
     * @param string $msg
     * @return CH_Detection
     */
    public function setSuccessMessage($msg)
    {
        $this->successMessage[] = $msg;
        return $this;
    }

    /**
     * 获取错误信息
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * 获取成功信息
     * @return multitype:
     */
    public function getSuccessMessage()
    {
        return $this->successMessage;
    }
}