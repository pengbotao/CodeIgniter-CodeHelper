<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'third_party/CodeHelper/Autoloader.php';

/**
 * 生成器模块
 * @author BobbyPeng<pengbotao@teiron.com>
 *
 */
class Code extends MY_Controller
{
    public $theme = array(
        'stylesheets_default' => '默认模版',
        'stylesheets_blacktie' => '黑色领结',
        'stylesheets_wintertide' => '冰雪冬季',
        'stylesheets_schoolpainting' => '青葱校园',
    );

    /**
     * CH初始化
     */
    public function __construct()
    {
        parent::__construct();
        CH_Autoloader::register();
    }

    public function index()
    {
        $this->setting();
    }

    /**
     * 初始化设置
     */
    public function setting()
    {
        $project = CH_Runtime::getProject();
        if(! isset($project['project_path'])) {
            $project['project_path'] = '../application';
        } else {
            $project['project_path'] = substr($project['project_path'], strlen(APPPATH));
        }
        $CodeHelper = new CH_CodeHelper();
        $this->view->render('code/setting', array(
                'project' => $project,
                'errors' => $CodeHelper->detection(),
                'theme' => $this->theme
        ));
    }

    /**
     * 处理初始化设置
     */
    public function setting_helper()
    {
        $project_name = $this->input->post('project_name', TRUE);
        $project_path = $this->input->post('project_path', TRUE);
        $tpl_type = $this->input->post('tpl_type', TRUE);
        $project_theme = $this->input->post('project_theme', TRUE);

        if(empty($project_name)) {
            echo '请填写项目名称';exit;
        }
        if(realpath(APPPATH.$project_path) !== false) {
            echo '生成目录已存在，请更换目录';exit;
        }
        if(! @mkdir(APPPATH.$project_path, 0777, true)) {
            echo '生成'.APPPATH.$project_path.'失败，请检测权限';exit;
        }
        if(! in_array($tpl_type, array('php', 'twig'))) {
            echo '请选择模版';exit;
        }
        if(! in_array($project_theme, array_keys($this->theme))) {
            echo '请选择主题';exit;
        }
        $data = array(
            'project_name' => $project_name,
            'tpl_type' => $tpl_type,
            'project_theme' => $project_theme,
            'project_path' => APPPATH.$project_path,
        );
        CH_Runtime::setProject($data);
        $CodeHelper = new CH_CodeHelper();
        try {
            $CodeHelper->initialize();
            echo '初始化完毕';
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    /**
     * 插件选择
     */
    public function module()
    {
        $CodeHelper = new CH_CodeHelper();
        $this->view->render('code/module', array(
            'project' => CH_Runtime::getProject(),
            'module' => $CodeHelper->getModuleList(),
        ));
    }

    /**
     * 生成插件模块
     */
    public function module_helper()
    {
        $project_module = $this->input->post('project_module', TRUE);
        $module = array();
        if(!empty($project_module)) {
            $module = explode('|', $project_module);
        }
        $project = CH_Runtime::getProject();
        $project['project_module'] = $module;
        CH_Runtime::setProject($project);
        
        $CodeHelper = new CH_CodeHelper();
        try {
            $CodeHelper->module();
            echo '模块生成完毕';
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * 控制器
     */
    public function controller()
    {
        $this->view->render('code/controller');
    }

    /**
     * 生成控制器
     */
    public function controller_helper()
    {
        $table_name = isset($_POST['table']) ? trim($_POST['table']) : NULL;
        $model_name = isset($_POST['model']) ? trim($_POST['model']) : NULL;
        $controller_name = isset($_POST['controller']) ? trim($_POST['controller']) : NULL;
    
        if(empty($table_name) || $table_name == "*") {
            $model_name = NULL;
            $controller_name = NULL;
        }
        $CodeHelper = new CH_CodeHelper();
        try {
            $CodeHelper->controller($table_name, $controller_name, $model_name);
            echo '控制器视图生成完毕';
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * 模型
     */
    public function model()
    {
        $this->view->render('code/model');
    }

    /**
     * 生成模型
     */
    public function model_helper()
    {
        $table_name = isset($_POST['table']) ? trim($_POST['table']) : NULL;
        $model_name = isset($_POST['model']) ? trim($_POST['model']) : NULL;
        
        if(empty($table_name) || $table_name == "*") {
            $model_name = NULL;
        }
        $CodeHelper = new CH_CodeHelper();
        try {
            $CodeHelper->model($table_name, $model_name);
            echo '模型生成完毕';
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * 类库
     */
    public function vendor()
    {
        $CodeHelper = new CH_CodeHelper();
        $this->view->render('code/vendor', array(
            'project' => CH_Runtime::getProject(),
            'vendor' => $CodeHelper->getVendorList(),
        ));
    }

    /**
     * 生成类库
     */
    public function vendor_helper()
    {
        $project_vendor = $this->input->post('project_vendor', TRUE);
        $vendor = array();
        if(!empty($project_vendor)) {
            $vendor = explode('|', $project_vendor);
        }
        $project = CH_Runtime::getProject();
        $project['project_vendor'] = $vendor;
        CH_Runtime::setProject($project);
        
        $CodeHelper = new CH_CodeHelper();
        try {
            $CodeHelper->vendor();
            echo '类库生成完毕';
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

/* End of file code.php */
/* Location: ./application/controllers/code.php */