<?php

namespace Addons\CurdForAdmin;
use Common\Controller\Addon;

/**
 * 后台增删改查插件插件
 * @author eecjimmy
 */

/**
 * __CONTROLLER_DESCRIPTION__		控制器名称描述，如新闻、动态等
 * __AUTHOR_DESCRIPTION__			作者描述信息
 * __CREATE_TIME__				    创建时间
 * __CONTROLLER_NAME__			    控制器名称
 * __MODEL_NAME__				    模型名称
 * __TABLE_NAME__				    表名
**/
define('ADDON_TPL_PATH', ONETHINK_ADDON_PATH . 'CurdForAdmin/Tpl/');
    class CurdForAdminAddon extends Addon{

        public $info = array(
            'name'=>'CurdForAdmin',
            'title'=>'后台增删改查插件',
            'description'=>'后台增删改查插件',
            'status'=>1,
            'author'=>'eecjimmy',
            'version'=>'0.1'
        );

        public $custom_adminlist = 'index.html';

        public $admin_list = array(true);

        public function install(){
            return true;
        }

        public function uninstall(){
            return true;
        }

        public function pageHeader(){
            return true;
        }


    }