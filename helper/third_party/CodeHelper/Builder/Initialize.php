<?php
/**
 * 初始化设置
 * 
 */
class CH_Builder_Initialize extends CH_Builder_Abstract
{
    /**
     * 初始化
     */
    public function handle()
    {
        $this->handleFolders();
        $this->handleConfig();
        $this->handleCore();
        $this->handleErrors();
        $this->handleHelpers();
        $this->handleLibraries();
        $this->handleService();
        $this->handleThirdParty();
        $this->handleBaseView();
    }

    /**
     * 初始化空目录
     */
    public function handleFolders()
    {
        $folders = array(
            'cache',
            'config/development',
            'controllers',
            'core',
            'errors',
            'helpers',
            'hooks',
            'language/english',
            'libraries',
            'logs',
            'models',
            'third_party',
            'views',
            'service',
        );
        $CH_Config = new CH_Config();
        foreach($folders as $key => $val) {
            $folders[$key] = $CH_Config->getProjectPath().'/'.$val;
        }
        CH_Template::createFolder($folders);
    }

    /**
     * 初始化配置目录
     */
    public function handleConfig()
    {
        $file = array(
            'config/autoload' => 'autoload.php',
            'config/config' => 'config.php',
            'config/constants' => 'constants.php',
            'config/doctypes' => 'doctypes.php',
            'config/foreign_chars' => 'foreign_chars.php',
            'config/hooks' => 'hooks.php',
            'config/migration' => 'migration.php',
            'config/mimes' => 'mimes.php',
            'config/pagination' => 'pagination.php',
            'config/profiler' => 'profiler.php',
            'config/routes' => 'routes.php',
            'config/smileys' => 'smileys.php',
            'config/user_agents' => 'user_agents.php',
        );
        $CH_Config = new CH_Config();
        if($CH_Config->getTplType() == 'twig') {
            $file['config/twig'] = 'twig.php';
        }
    
        $data = array();
        foreach($file as $key => $val) {
            $this->_handle($key, $CH_Config->getInitFile($val, 'config'), $data);
        }
        if (! defined('ENVIRONMENT') OR ! file_exists($file_path = APPPATH.'config/'.ENVIRONMENT.'/database.php'))    {
            if (! file_exists($file_path = APPPATH.'config/database.php'))    {
                $file_path = false;
            }
        }
        if($file_path) {
            CH_Template::copyFile($file_path, $CH_Config->getInitFile('database.php', 'config'));
        }
    }

    /**
     * 初始化core目录
     */
    public function handleCore()
    {
        $file = array(
            'core/MY_Controller' => 'MY_Controller.php',
            'core/MY_Model' => 'MY_Model.php',
            'core/MY_Input' => 'MY_Input.php',
            'core/MY_Loader' => 'MY_Loader.php',
            'core/MY_Service' => 'MY_Service.php',
        );
        $CH_Config = new CH_Config();
        $data = array(
            'tpl_type' => $CH_Config->getTplType(),
        );
        foreach($file as $key => $val) {
            $this->_handle($key, $CH_Config->getInitFile($val, 'core'), $data);
        }
    }

    /**
     * 初始化错误文件夹
     */
    public function handleErrors()
    {
        $file = array(
            'errors/error_404' => 'error_404.php',
            'errors/error_db' => 'error_db.php',
            'errors/error_general' => 'error_general.php',
            'errors/error_php' => 'error_php.php',
        );
        $CH_Config = new CH_Config();
    
        $data = array();
        foreach($file as $key => $val) {
            $this->_handle($key, $CH_Config->getInitFile($val, 'error'), $data);
        }
    }

    /**
     * 初始化helper目录
     */
    public function handleHelpers()
    {
        $file = array(
            'helpers/MY_url_helper' => 'MY_url_helper.php',
            'helpers/app_helper' => 'app_helper.php'
        );
        $data = array();
        $CH_Config = new CH_Config();
        foreach($file as $key => $val) {
            $this->_handle($key, $CH_Config->getInitFile($val, 'helper'), $data);
        }
    }

    /**
     * 初始化类库
     */
    public function handleLibraries()
    {
        $file = array(
            'libraries/MY_Pagination' => 'MY_Pagination.php',
            'libraries/MY_Session' => 'MY_Session.php',
            'libraries/Captcha' => 'Captcha.php'
        );
        $CH_Config = new CH_Config();
        if($CH_Config->getTplType() != 'php') {
            $file['libraries/Twig'] = 'Twig.php';
        }
        $data = array(
            'tpl_type' => $CH_Config->getTplType(),
        );
        foreach($file as $key => $val) {
            $this->_handle($key, $CH_Config->getInitFile($val, 'library'), $data);
        }
    }

    public function handleService()
    {
        $file = array(
            'service/common/helper_service' => 'common/helper_service.php',
            'service/common/pagination_service' => 'common/pagination_service.php',
            'service/user_service' => 'user_service.php',
        );
        $CH_Config = new CH_Config();
        if($CH_Config->getTplType() == 'php') {
            $render = '$this->load->view';
        } else {
            $render = '$this->view->render';
        }
        $data = array(
            'tpl_type' => $CH_Config->getTplType(),
            'render' => $render,
        );
        foreach($file as $key => $val) {
            $this->_handle($key, $CH_Config->getInitFile($val, 'service'), $data);
        }
    }
    /**
     * 初始化第三方目录
     */
    public function handleThirdParty()
    {
        $CH_Config = new CH_Config();
        if($CH_Config->getTplType() == 'twig' && ! file_exists($CH_Config->getProjectPath().'/third_party/Twig')) {
            $CH_Template = new CH_Template();
            $CH_Template->copyFolder(APPPATH.'third_party/Twig', $CH_Config->getProjectPath().'/third_party/Twig');
        }
    }

    /**
     * 初始化基本视图目录
     */
    public function handleBaseView()
    {
        $CH_Config = new CH_Config();
        if($CH_Config->getTplType() == 'php') {
            $file = array(
                    'views/'.$CH_Config->getTplType().'/base/header' => 'base/header'.$CH_Config->getTplExt(),
                    'views/'.$CH_Config->getTplType().'/base/sidebar' => 'base/sidebar'.$CH_Config->getTplExt(),
                    'views/'.$CH_Config->getTplType().'/base/footer' => 'base/footer'.$CH_Config->getTplExt(),
                    'views/'.$CH_Config->getTplType().'/base/msg' => 'base/msg'.$CH_Config->getTplExt(),
            );
        } elseif($CH_Config->getTplType() == 'twig') {
            $file = array(
                    'views/'.$CH_Config->getTplType().'/base/base' => 'base/base'.$CH_Config->getTplExt(),
                    'views/'.$CH_Config->getTplType().'/base/main' => 'base/main'.$CH_Config->getTplExt(),
                    'views/'.$CH_Config->getTplType().'/base/menu' => 'base/menu'.$CH_Config->getTplExt(),
                    'views/'.$CH_Config->getTplType().'/base/msg' => 'base/msg'.$CH_Config->getTplExt(),
            );
        }
        $data = array(
                'project_name' => $CH_Config->getProjectName(),
                'menus' => CH_Runtime::menu(),
                'project_theme' => $CH_Config->projectTheme,
        );
        
        foreach($file as $key => $val) {
            $data['view_file_name'] = $val;
            $this->_handle($key, $CH_Config->getInitFile($val, 'view'), $data);
        }
    }
}