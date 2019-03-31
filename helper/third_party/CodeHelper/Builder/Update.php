<?php
/**
 * 
 * 更新初始化的文件
 *
 */
class CH_Builder_Update extends CH_Builder_Abstract
{
    /**
     * 项目运行中更新操作
     */
    public function update()
    {
        $this->updateMenu();
        $this->updateRoute();
    }
    
    /**
     * 更新菜单
     */
    public function updateMenu()
    {
        $CH_Config = new CH_Config();
        if($CH_Config->getTplType() == 'php') {
            $file = array(
                'views/'.$CH_Config->getTplType().'/base/sidebar' => 'base/sidebar'.$CH_Config->getTplExt(),
            );
        } elseif($CH_Config->getTplType() == 'twig') {
            $file = array(
                'views/'.$CH_Config->getTplType().'/base/menu' => 'base/menu'.$CH_Config->getTplExt(),
            );
        }
        $CH_Module_Manager = new CH_Module_Manager();
        $data = array(
            'project_name' => $CH_Config->getProjectName(),
            'menus' => CH_Runtime::menu(),
            'module_menus' => $CH_Module_Manager->getModuleMenu($CH_Config->getProjectModule()),
        );
        foreach($file as $key => $val) {
            $data['view_file_name'] = $val;
            $this->_handle($key, $CH_Config->getInitFile($val, 'view'), $data);
        }
    }
    
    /**
     * 更新路由入口
     */
    public function updateRoute()
    {
        $file = array(
            'config/routes' => 'routes.php',
        );
        $menu = CH_Runtime::menu();
        foreach($menu as $db => $tables) {
            foreach($tables as $key => $val) {
                $default_controller = $key;
                break;
            }
        }
        if(! isset($default_controller) || empty($default_controller)) {
            $default_controller = 'admin';
        }
        $data = array(
            'default_controller' => $default_controller,
        );
        $CH_Config = new CH_Config();
        foreach($file as $key => $val) {
            $this->_handle($key, $CH_Config->getInitFile($val, 'config'), $data);
        }
    }

    /**
     * 更新右上角菜单
     */
    public function updateTopNavbar()
    {
        $CH_Config = new CH_Config();
        if($CH_Config->getTplType() == 'php') {
            $file = array(
                'views/'.$CH_Config->getTplType().'/base/header' => 'base/header'.$CH_Config->getTplExt(),
            );
        } elseif($CH_Config->getTplType() == 'twig') {
            $file = array(
                'views/'.$CH_Config->getTplType().'/base/main' => 'base/main'.$CH_Config->getTplExt(),
            );
        }
        $CH_Module_Manager = new CH_Module_Manager();
        $data = array(
            'project_name' => $CH_Config->getProjectName(),
            'menus' => CH_Runtime::menu(),
            'project_theme' => $CH_Config->projectTheme,
            'nav_bar' => $CH_Module_Manager->getContentByMethod($CH_Config->getProjectModule(), 'hookTopNavbar'),
        );
        
        foreach($file as $key => $val) {
            $data['view_file_name'] = $val;
            $this->_handle($key, $CH_Config->getInitFile($val, 'view'), $data);
        }
    }
    
    /**
     * 更新helper类库
     */
    public function updateHelper()
    {
        $file = array(
            'service/common/helper_service' => 'common/helper_service.php',
        );
        $CH_Config = new CH_Config();
        $CH_Module_Manager = new CH_Module_Manager();
        $data = array(
            'tpl_type' => $CH_Config->getTplType(),
            'module_helper' => $CH_Module_Manager->getContentByMethod($CH_Config->getProjectModule(), 'hookHelper'),
        );
        foreach($file as $key => $val) {
            $this->_handle($key, $CH_Config->getInitFile($val, 'service'), $data);
        }
    }
}