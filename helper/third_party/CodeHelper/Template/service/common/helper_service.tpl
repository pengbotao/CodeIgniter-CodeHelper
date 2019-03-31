<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 应用公用服务
 *
 */
class Helper_service extends MY_Service
{
    public $user;
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->user = $this->session->userdata('_user');
        $this->load->helper(array('url', 'string'));
{% if tpl_type != 'php' %}
        $this->load->library('Twig', NULL, 'view');
        $this->view->assign('sys_user', $this->user);
{% else %}
        $this->load->vars('sys_user', $this->user);
{% endif %}
{{ module_helper|raw }}
    }
    /**
     * 提示信息
     * 
     * @param string $msg 提示信息
     * @param string $url 跳转URL
     * @param string $url_title 跳转标题
     */
    public function msg($msg, $url = NULL, $url_title = NULL)
    {
{% if tpl_type != 'php' %}
        $this->view->render('base/msg', array(
            'message' => $msg,
            'url' => $url,
            'url_title' => $url_title,
        ));
{% else %}
        echo $this->load->view('base/msg', array(
            'message' => $msg,
            'url' => $url,
            'url_title' => $url_title,
        ), true);
        exit;
{% endif %}
    }

    /**
     * 跳转
     * @param array $route 键0为路由名，之后为参数
     * @param number $http_response_code
     */
    public function redirect($route = '',  $http_response_code = 302)
    {
        if(is_array($route)) {
            $route = create_url($route[0], array_slice($route, 1));
        }
        header("Location: ".$route, TRUE, $http_response_code);
        exit;
    }

    /**
     * 判断用户是否登录
     * @return boolean
     */
    public function isLogin()
    {
        if(isset($this->user['is_login']) && $this->user['is_login'] === true) {
            return true;
        }
        return false;
    }

    /**
     * 登录检测
     */
    public function hasLogin() {
        if(! $this->isLogin()) {
            $this->redirect(create_url('login', array('url' => get_current_url())));
        }
    }
}

/* End of file helper_service.php */
/* Location: ./application/service/helper_service.php */