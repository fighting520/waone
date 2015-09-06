<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: yangweijie <yangweijiester@gmail.com> <code-tech.diandian.com>
// +----------------------------------------------------------------------
namespace Addons\SiteStat;
use Common\Controller\Addon;
use Admin\Model\AuthGroupModel;
use Admin\Controller\AdminController;

/**
 * 系统环境信息插件
 * @author thinkphp
 */
class SiteStatAddon extends Addon{

    public $info = array(
        'name'=>'SiteStat',
        'title'=>'站点统计信息',
        'description'=>'统计站点的基础信息',
        'status'=>1,
        'author'=>'thinkphp',
        'version'=>'0.1'
    );

    public function install(){
        return true;
    }

    public function uninstall(){
        return true;
    }

    //实现的AdminIndex钩子方法
    public function AdminIndex($param){
        $config = $this->getConfig();
        $this->assign('addons_config', $config);
        if($config['display']){
            $info['user_wait']		=	M('Member')->where('status = 2')->count();
            $info['action']		=	M('ActionLog')->count();
            if ( !IS_ROOT ) {
//             	$cate_auth  =   AuthGroupModel::getAuthCategories(UID);
//             	if($cate_auth){
//             		$map['category_id']    =   array('IN',$cate_auth);
//             	}else{
//             		$map['category_id']    =   -1;
//             	}
            	$group  =   AuthGroupModel::getUserGroup(UID);
            	if($group[0]['group_id']==2||IS_ROOT){
//             		if(empty($data['uid'])){
//             			$data['uid'] = $data['category_id'];
//             		}
            	}else{
            		$map['uid'] =UID;
            	}
            }
            
            $info['document']	=	M('Document')->where('  status =1 ')->count();
            
       
            $map['status']  =   3;
             
            $info['document_draft'] = M('Document')->where('uid='.UID.' and status =3 ')->count();
            
            
            $info['document_my'] = M('Document')->where('uid='.UID.' and status  in (1,2) ')->count();
            
            
            $map['status']  =   2;
           
            $info['document_wait'] = M('Document')->where('  status =2 ')->count();
      
//             $map['status']  =   4;
//             $info['document_past'] = M('Document')->where('  status =4   ')->count();
            
            
            $info['document_unpast'] = M('Document')->where('  status =4  and uid='.UID)->count();
            
            $cate_auth  =   AuthGroupModel::getAuthCategories(UID);
             
            
            $group  =   AuthGroupModel::getUserGroup(UID);
            if($group[0]['group_id']==2){
            	
            	$url['document_add'] = UID ;
            }else{
	            foreach( $cate_auth as $k=>$v) {
	            	if($v != '1') {
	            		$url['document_add'] = $v ;
	            	};
	            }
            }
            
            
          $user =   M('Member')->where('uid='.UID)->find();
            
          $this->assign("user",$user);
            
            $this->assign('info',$info);
            
            $this->assign('url',$url);
            
            $s = AdminController::checkRule('Admin/addons/sitestat/count');
            
            //获取统计权限
            $this->assign('show_count', IS_ROOT || AdminController::checkRule('Admin/addons/sitestat/count'));
            
            $this->display('info');
        }
    }
}