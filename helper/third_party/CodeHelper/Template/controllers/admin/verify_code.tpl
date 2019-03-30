<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 验证码
 */
class Verify_code extends MY_Controller
{
    private $_captcha_key = '_capthcha_code';
    
    /**
     * 显示验证码
     */
    public function index()
    {
        $this->load->library('captcha');
        $this->captcha->doimg();
        $this->session->set_userdata($this->_captcha_key, strtolower($this->captcha->getCode()));
        $this->captcha->outPut();
    }
    
    /**
     * 验证码校验页面
     */
    public function check()
    {
        $rtn = 'false';
        $captcha = $this->input->post('captcha');
        if(strtolower($captcha) == $this->session->userdata($this->_captcha_key)) {
            $rtn = 'true';
        }
        echo $rtn;
    }
}

/* End of file captcha.php */
/* Location: ./application/controllers/captcha.php */