<?php
/**
 * @description 生成后台增删改查
 * @Author: eecjimmy
 * @CreateTime: 14-9-29 下午3:41
 */

namespace Addons\CurdForAdmin\Controller;

use Admin\Controller\AdminController;

class CreateController extends AdminController
{

    protected $controller_path; // 需要生成的控制器所在目录
    protected $view_path;       // 需要生成的模板所在目录
    protected $module_path;     // 需要生成的模型所在目录
    protected $addon_path;      // 当前插件目录

    public function _initialize()
    {
        parent::_initialize();
        $this->controller_path  =   MODULE_PATH . 'Controller/';
        $this->view_path        =   MODULE_PATH . 'View/';
        $this->module_path      =   MODULE_PATH . 'Model/';
        $this->addon_path       =   ONETHINK_ADDON_PATH . 'CurdForAdmin/';
    }

    public function create()
    {
        if (IS_POST) {
            $param['controller_description']    =   I('post.controller_description');        // 控制器描述
            $param['author_description']        =   I('post.author_description');            // 作者描述
            $param['controller_name']           =   I('post.controller_name');               // 控制器名称
            $param['table_name']                =   I('post.table_name');                    // 表名称
            $param['module_name']               =   I('post.module_name');                   // 模型名称
            empty($param['controller_name']) && $this->error('请输入控制器名称');
            $this->is_var($param['controller_name']) || $this->error('控制器名称不合法');
            $param['controller_name'] = ucfirst(strtolower($param['controller_name']));
            empty($param['controller_description']) && $param['controller_description'] = 'CurdForAdmin插件自动生成';
            empty($param['author_description']) && $param['author_description'] = 'CurdForAdmin插件自动生成';
            empty($param['table_name']) && $param['table_name'] = strtolower($param['controller_name']);            // 表名未填写,采用控制器名称
            empty($param['module_name']) && $param['module_name'] = ucfirst(strtolower($param['controller_name'])); // 模型名称未填写, 采用控制器名称
            $param['module_name'] = ucfirst(strtolower($param['module_name']));
            $controller_filename    =   $this->controller_path . $param['controller_name'].'Controller.class.php';
            $module_filename        =   $this->module_path . $param['module_name'] . 'Module.class.php';
            $view_dir               =   $this->view_path . $param['controller_name'];
            $view_add_filename      =   $view_dir.'/form.html';
            $view_index_filename    =   $view_dir.'/index.html';

            file_exists($controller_filename) && $this->error('控制器（'.$controller_filename.'）已经存在');
            file_exists($module_filename) && $this->error('模型（'.$module_filename.'）已经离存在');
            file_exists($view_dir) && $this->error('模板目录（'.$view_dir.'）已经存在');
            file_exists($view_add_filename) && $this->error('添加数据模板（'.$view_add_filename.'）已经存在');
            file_exists($view_index_filename) && $this->error('列表数据模板（'.$view_index_filename.'）已经存在');
            $search=array(
                '{__CONTROLLER_DESCRIPTION__}',     // 控制器描述
                '{__AUTHOR_DESCRIPTION__}',         // 作者描述
                '{__CREATE_TIME__}',                // 创建时间
                '{__CONTROLLER_NAME__}',            // 控制器名称
                '{__MODEL_NAME__}',                 // 模型名称
                '{__TABLE_NAME__}',                 // 表名称
                '{__TABLEPREX__}',                  // 表前缀
                '{__TABLE_DESCRIPTION__}',          // 表描述
            );
            $replace = array(
                $param['controller_description'],
                $param['author_description'],
                date('Y-m-d H:i:s'),
                $param['controller_name'],
                $param['module_name'],
                $param['table_name'],
                C('DB_PREFIX'),
                '插件自动生成 - '.$param['controller_description']
            );
            if(mkdir($view_dir)){

                // 获取模板
                $controller_code    =   file_get_contents($this->addon_path.'Tpl/Controller.tpl');
                $module_code        =   file_get_contents($this->addon_path.'Tpl/Module.tpl');
                $view_add_code      =   file_get_contents($this->addon_path.'Tpl/form.html.tpl');
                $view_index_code    =   file_get_contents($this->addon_path.'Tpl/index.html.tpl');
                $sql_code           =   file_get_contents($this->addon_path.'Tpl/CreateTable.sql.tpl');

                // 替换标签
                $controller_code    =   str_replace($search,$replace,$controller_code);
                $view_add_code      =   str_replace($search,$replace,$view_add_code);
                $view_index_code    =   str_replace($search,$replace,$view_index_code);
                $module_code        =   str_replace($search,$replace,$module_code);
                $sql_code           =   str_replace($search,$replace,$sql_code);

                // 生成文件以及执行sql
                file_put_contents($controller_filename,$controller_code) || $this->error('生成控制器失败');
                file_put_contents($view_add_filename,$view_add_code) || $this->error('生成添加/编辑模板失败');
                file_put_contents($view_index_filename,$view_index_code) || $this->error('生成列表模板失败');
                file_put_contents($module_filename,$module_code) || $this->error('生成模型失败');

              //  $this->execute_mulsql($sql_code) || $this->error('生成数据表失败');
                $this->success('生成成功');
            }
            else{
                $this->error('创建模板目录（'.$view_dir.'）失败');
            }
        } else {
            $this->error('错误的来路');
        }
    }

    /**
     * 是否合法变量名
     * 规定合法变量名为：字母或下划线开头，后跟字母、数字、下划线、短杠。
     * 不能使用汉字等双字节字符。
     * @param string $var
     * @return boolean
     */
    protected function is_var($var)
    {
        return !!preg_match('/^[a-z_][a-z0-9-_]*$/i', $var);
    }

    /**
     * 执行多条
     * @param string $sql 使用;隔开的多条sql
     * @return boolean
    **/
//     protected function execute_mulsql($sql){
//         $sql = explode(';',$sql);
//         if(!$sql) return false;
//         foreach($sql as $v){
//             $cur_sql = $v.';';
//             $result = M()->execute($cur_sql);
//             if($result===false) return false;
//         }
//         return true;
//     }
} 