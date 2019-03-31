<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'third_party/Twig/Autoloader.php';

/**
 * Twig模版引擎
 *
 */
class Twig 
{
    public $ci;

    public $twig;

    public $config;

    private $data = array();

    /**
     * 读取配置文件twig.php并初始化设置
     * 
     */
    public function __construct($config = NULL)
    {
        $this->ci = & get_instance ();
        if(empty($config)) {
            $config = 'twig';
        }
        if(! is_array($config)) {
            $config = $this->ci->config->load($config, true);
        }
        $config_default = array(
            'cache_dir' => false,
            'debug' => false,
            'auto_reload' => true,
            'extension' => '.tpl',
        );
        $this->config = array_merge($config_default, $config);
        Twig_Autoloader::register ();
        $loader = new Twig_Loader_Filesystem ($this->config['template_dir']);
        $this->twig = new Twig_Environment ($loader, array (
                'cache' => $this->config['cache_dir'],
                'debug' => $this->config['debug'],
                'auto_reload' => $this->config['auto_reload'], 
        ) );

        $this->ci->load->helper(array('url'));
        $this->twig->addFunction(new Twig_SimpleFunction('site_url', 'site_url'));
        $this->twig->addFunction(new Twig_SimpleFunction('base_url', 'base_url'));
    }

    /**
     * 给变量赋值
     * 
     * @param string|array $var
     * @param string $value
     */
    public function assign($var, $value = NULL)
    {
        if(is_array($var)) {
            foreach($val as $key => $val) {
                $this->data[$key] = $val;
            }
        } else {
            $this->data[$var] = $value;
        }
    }

    /**
     * 模版渲染
     * 
     * @param string $template 模板名
     * @param array $data 变量数组
     * @param string $return true返回 false直接输出页面
     * @return string
     */
    public function render($template, $data = array(), $return = FALSE)
    {
        $template = $this->twig->loadTemplate ( $this->getTemplateName($template) );
        $data = array_merge($this->data, $data);
        if ($return === TRUE) {
            return $template->render ( $data );
        } else {
            return $template->display ( $data );
        }
    }

    /**
     * 获取模版名
     * 
     * @param string $template
     */
    public function getTemplateName($template)
    {
        $default_ext_len = strlen($this->config['extension']);
        if(substr($template, -$default_ext_len) != $this->config['extension']) {
            $template .= $this->config['extension'];
        }
        
        return $template;
    }

    /**
     * 字符串渲染
     * 
     * @param string $string 需要渲染的字符串
     * @param array $data 变量数组
     * @param string $return true返回 false直接输出页面
     * @return string
     */
    public function parse($string, $data = array(), $return = FALSE)
    {
        $string = $this->twig->loadTemplate ( $string );
        $data = array_merge($this->data, $data);
        if ($return === TRUE) {
            return $string->render ( $data );
        } else {
            return $string->display ( $data );
        }
    }
}

/* End of file Twig.php */
/* Location: ./application/libraries/Twig.php */