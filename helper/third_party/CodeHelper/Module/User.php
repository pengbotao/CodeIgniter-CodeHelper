<?php
/**
 * 用户登录模块
 * 
 */
class CH_Module_User extends CH_Builder_Abstract implements CH_Module_Interface
{
    /**
     * @see CH_Module_Interface::getModuleSwitch()
     */
    public function getModuleSwitch()
    {
        return true;
    }

    /**
     * @see CH_Module_Interface::getModuleName()
     */
    public function getModuleName()
    {
        return '用户管理';
    }

    /**
     * 用户管理路由地址
     */
    public function getModuleRoute()
    {
        return 'admin';
    }

    /**
     * @see CH_Module_Interface::handle()
     */
    public function handle()
    {
        $this->handleModel();
        $this->handleView();
        $this->handleController();
        $CH_Builder_Update = new CH_Builder_Update();
        $CH_Builder_Update->update();
        $CH_Builder_Update->updateTopNavbar();
        $CH_Builder_Update->updateHelper();
    }

    /**
     * 生成模型
     */
    public function handleModel()
    {
        $CH_Builder_Model = new CH_Builder_Model();
        $entity = CH_Loader_EntityLoader::load('admin_user');
        if(!isset($entity[0]) || ! $entity[0] instanceof CH_Entity) {
            throw new CH_Exception('用户管理安装失败，程序终止：加载admin_user表失败');
        }
        $entity = $entity[0];
        $CH_Builder_Model->builder($entity);
    }

    /**
     * 生成视图
     */
    public function handleView()
    {
        $CH_Config = new CH_Config();
        $file['views/'.$CH_Config->getTplType().'/admin/login'] = 'admin/login'.$CH_Config->getTplExt();
        $data = array(
            'project_name' => $CH_Config->getProjectName(),
            'project_theme' => $CH_Config->projectTheme,
        );
        foreach($file as $key => $val) {
            $data['view_file_name'] = $val;
            $this->_handle($key, $CH_Config->getInitFile($val, 'view'), $data);
        }
    }
    
    /**
     * 生成控制器
     */
    public function handleController()
    {
        $table_name = 'admin_user';
        $entity = CH_Loader_EntityLoader::load($table_name);
        if(!isset($entity[0]) || ! $entity[0] instanceof CH_Entity) {
            throw new CH_Exception('用户管理安装失败，程序终止：加载admin_user表失败');
        }
        $entity = $entity[0];
        $CH_Builder_Controller = new CH_Builder_Controller();
        $CH_Builder_Controller->builder($entity, 'admin', $table_name, false);

        $CH_Builder_Model = new CH_Builder_Model();
        $file = array(
            'controllers/admin/login' => 'login.php',
            'controllers/admin/verify_code' => 'verify_code.php',
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
            'model_name' => strtolower($CH_Builder_Model->getModelName($table_name, $entity->table)),
            'entity' => $entity,
        );
        foreach($file as $key => $val) {
            $this->_handle($key, $CH_Config->getInitFile($val, 'controller'), $data);
        }
    }
    
    /**
     * 更新页面右上角菜单
     * @return string
     */
    public function hookTopNavbar()
    {
        $top_navbar = NULL;
        $CH_Config = new CH_Config();
        if($CH_Config->getTplType() == 'php') {
            $top_navbar = <<< EOT
            <li id="fat-menu">
                <a href="#"> <i class="icon-user"></i> <?php echo \$sys_user['nickname'];?></a>
            </li>
            <li id="fat-menu"><a href="<?php echo site_url('login/logout');?>"><i class="icon-off"></i></a></li>
EOT;
        } elseif($CH_Config->getTplType() == 'twig') {
            $top_navbar = <<< EOT
            <li id="fat-menu">
                <a href="#"> <i class="icon-user"></i> {{ sys_user.nickname }}</a>
            </li>
            <li id="fat-menu"><a href="{{ site_url('login/logout') }}"><i class="icon-off"></i></a></li>
EOT;
        }
        return $top_navbar;
    }

    /**
     * helper文件更新
     * @return string
     */
    public function hookHelper()
    {
        $login_helper = <<< EOT
        if(! in_array(\$this->router->fetch_class(), array('login', 'verify_code'))) {
            \$this->hasLogin();
        }
EOT;
        return $login_helper;
    }
}