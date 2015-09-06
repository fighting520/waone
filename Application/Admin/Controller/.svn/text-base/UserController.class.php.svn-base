<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Controller;
use User\Api\UserApi;
use Admin\Model\AuthGroupModel;

/**
 * 后台用户控制器
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class UserController extends AdminController {

    /**
     * 用户管理首页
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function index(){
        $nickname       =   I('nickname');
        $map['status']  =   array('egt',0);
        if(is_numeric($nickname)){
            $map['uid|nickname']=   array(intval($nickname),array('like','%'.$nickname.'%'),'_multi'=>true);
        }else{
            $map['nickname']    =   array('like', '%'.(string)$nickname.'%');
        }

        $list   = $this->lists('Member', $map);
        int_to_string($list);
        $this->assign('_list', $list);
        $this->meta_title = '用户信息';
        $this->display();
    }
    
    
    /**
     * 用户审核
     * @author lipeng <zuojiazi@vip.qq.com>
     */
    public function examine(){
    	$nickname       =   I('nickname');
    	$map['status']  =   2;
    	if(is_numeric($nickname)){
    		$map['uid|nickname']=   array(intval($nickname),array('like','%'.$nickname.'%'),'_multi'=>true);
    	}else{
    		$map['nickname']    =   array('like', '%'.(string)$nickname.'%');
    	}
    
    	
    	
    	$list   = $this->lists('Member', $map);
    	int_to_string($list);
    	$this->assign('_list', $list);
    	$this->meta_title = '用户审核';
    	$this->display();
    }
    

    /**
     * 修改昵称初始化
     * @author huajie <banhuajie@163.com>
     */
    public function updateNickname(){
        $nickname = M('Member')->getFieldByUid(UID, 'nickname');
        $this->assign('nickname', $nickname);
        $this->meta_title = '修改昵称';
        $this->display('updatenickname');
    }

    /**
     * 修改昵称提交
     * @author huajie <banhuajie@163.com>
     */
    public function submitNickname(){
        //获取参数
        $nickname = I('post.nickname');
        $password = I('post.password');
        empty($nickname) && $this->error('请输入昵称');
        empty($password) && $this->error('请输入密码');

        //密码验证
        $User   =   new UserApi();
        $uid    =   $User->login(UID, $password, 4);
        ($uid == -2) && $this->error('密码不正确');

        $Member =   D('Member');
        $data   =   $Member->create(array('nickname'=>$nickname));
        if(!$data){
            $this->error($Member->getError());
        }

        $res = $Member->where(array('uid'=>$uid))->save($data);
        
        
        $udata = array('username'=>$nickname,'password'=>$password);
        $Api    =   new UserApi();
        $status    =   $Api->updateInfo(UID, $password, $udata);

        if($res){
            $user               =   session('user_auth');
            $user['username']   =   $data['nickname'];
            session('user_auth', $user);
            session('user_auth_sign', data_auth_sign($user));
            $this->success('修改昵称成功！');
        }else{
            $this->error('修改昵称失败！');
        }
    }

    /**
     * 修改密码初始化
     * @author huajie <banhuajie@163.com>
     */
    public function updatePassword(){
        $this->meta_title = '修改密码';
        $this->display('updatepassword');
    }

    /**
     * 修改密码提交
     * @author huajie <banhuajie@163.com>
     */
    public function submitPassword(){
        //获取参数
        $password   =   I('post.old');
        empty($password) && $this->error('请输入原密码');
        $data['password'] = I('post.password');
        empty($data['password']) && $this->error('请输入新密码');
        $repassword = I('post.repassword');
        empty($repassword) && $this->error('请输入确认密码');

        if($data['password'] !== $repassword){
            $this->error('您输入的新密码与确认密码不一致');
        }

        $Api    =   new UserApi();
        $res    =   $Api->updateInfo(UID, $password, $data);
        if($res['status']){
            $this->success('修改密码成功！');
        }else{
            $this->error($res['info']);
        }
    }

    /**
     * 用户行为列表
     * @author huajie <banhuajie@163.com>
     */
    public function action(){
        //获取列表数据
        $Action =   M('Action')->where(array('status'=>array('gt',-1)));
        $list   =   $this->lists($Action);
        int_to_string($list);
        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);

        $this->assign('_list', $list);
        $this->meta_title = '用户行为';
        $this->display();
    }

    /**
     * 新增行为
     * @author huajie <banhuajie@163.com>
     */
    public function addAction(){
        $this->meta_title = '新增行为';
        $this->assign('data',null);
        $this->display('editaction');
    }

    /**
     * 编辑行为
     * @author huajie <banhuajie@163.com>
     */
    public function editAction(){
        $id = I('get.id');
        empty($id) && $this->error('参数不能为空！');
        $data = M('Action')->field(true)->find($id);

        $this->assign('data',$data);
        $this->meta_title = '编辑行为';
        $this->display('editaction');
    }

    /**
     * 更新行为
     * @author huajie <banhuajie@163.com>
     */
    public function saveAction(){
        $res = D('Action')->update();
        if(!$res){
            $this->error(D('Action')->getError());
        }else{
            $this->success($res['id']?'更新成功！':'新增成功！', Cookie('__forward__'));
        }
    }

    /**
     * 会员状态修改
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function changeStatus($method=null){
        $id = array_unique((array)I('id',0));
        $examine = I('examine',0);
        
        if( in_array(C('USER_ADMINISTRATOR'), $id)){
            $this->error("不允许对超级管理员执行该操作!");
        }
        $id = is_array($id) ? implode(',',$id) : $id;
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $map['uid'] =   array('in',$id);
        switch ( strtolower($method) ){
            case 'forbiduser':
                $this->forbid('Member', $map );
                break;
            case 'resumeuser':
            	
                
                if ($examine==-30) {
                	$uid = I('id');
                	$udata = array('status'=>1);
                	$Member = D('Member');
                	$res = $Member->where(array('uid'=>$uid))->save($udata);
                	
                	$gid = I('group_id');
                	if( empty($uid) ){
                		$this->error('参数有误');
                	}
                	$AuthGroup = D('AuthGroup');
                	$member = M('Member')->where(array('uid'=>$uid))->find();
                	if(is_numeric($uid)){
                		if ( is_administrator($uid) ) {
                			$this->error('该用户为超级管理员');
                		}
                	
                		if( !$member ){
                			$this->error('用户不存在');
                		}
                	}
                	
                	if( $gid && !$AuthGroup->checkGroupId($gid)){
                		$this->error($AuthGroup->error);
                	}
                	
                	$lanmu = M('Category')->field('title')->where(array('id'=>$member['lanmu']))->find();
                	
                	if ( $AuthGroup->addToGroup($uid,$gid) ){
                		$res = sendmail($member['email'],"挖哇编辑审核通过","您申请的挖哇".$lanmu."频道编辑已经审核通过了，请通过以下地址 ".C(WEB_URL)."/waone/admin.php?s=/Public/login.html进行登陆操作。<br>谢谢您的支持。");
                		if($res){
                			//	$this->success('操作成功!',U('index'));
                			$this->success('审核成功',U('User/examine'));
                			//  $this->error("错误测试");
                			//   echo  "操作成功";
                		}else{
                			$this->error('邮件发送不成功'.$res);
                			//echo "邮件发送不成功！";
                		}
                	}else{
                		$this->error($AuthGroup->getError());
                	}
                }else{
                	$this->resume('Member', $map );
                	
                }
                
                
                
                break;
            case 'deleteuser':
                $this->delete('Member', $map );
                break;
            case 'reject':
            	$this->reject('Member',$map);
            	$uid = I('id');
            	$reason = I('reason',0);
            	$member = M('Member')->where(array('uid'=>$uid))->find();
            	$res = sendmail($member['email'],"挖哇编辑审核未通过","您申请的挖哇".$lanmu."频道编辑没有通过审核。原因如下：<br>".$reason."<br>谢谢您的支持。");
            	if($res){
            		//	$this->success('操作成功!',U('index'));
            		$this->success('操作成功',U('User/examine'));
            		//  $this->error("错误测试");
            		//   echo  "操作成功";
            	}else{
            		$this->error('邮件发送不成功'.$res);
            		//echo "邮件发送不成功！";
            	}
            	    
            default:
                $this->error('参数非法');
        }
    }

    public function add($username = '', $password = '', $repassword = '', $email = '', $mobile = '',$pimg='',$card='',$remark='',$lanmu='',$bqname=''){
        if(IS_POST){
            /* 检测密码 */
            if($password != $repassword){
                $this->error('密码和重复密码不一致！');
            }
         $bqarray =  explode("、",$bqname);
       $bqsize = count($bqarray);
       if($bqsize>3){
       	$this->error('标签不能大于三个！');
       }
        
            

            /* 调用注册接口注册用户 */
            $User   =   new UserApi;
            $uid    =   $User->register($username, $password, $email, $mobile = '',$pimg,$card,$remark,$lanmu);
            if(0 < $uid){ //注册成功
               $user = array('uid' => $uid, 'nickname' => $username, 'status' => 1,
						'password' => $password,
						'email'    => $email,
						'mobile'   => $mobile,
						'reg_time' => NOW_TIME,
						'reg_ip'   => get_client_ip(1),
						'pimg'=>$pimg,
						'card'=>$card,
						'remark'=>$remark,
						'lanmu'=>$lanmu,
               		'bqname'=>$bqname
						
				);	
                if(!M('Member')->add($user)){
                    $this->error('用户添加失败！');
                } else {
                    $this->success('用户添加成功！',U('index'));
                }
            } else { //注册失败，显示错误信息
                $this->error($this->showRegError($uid));
            }
        } else {
            $this->meta_title = '新增用户';
            $this->display();
        }
    }
    
    
    /**
     * 文档编辑页面初始化
     * @author huajie <banhuajie@163.com>
     */
    public function edit(){
    	
    
    	$id     =   I('get.id','');
    	
    	
    	
    
    	if(empty($id)){
    		//$this->error('参数不能为空！');
    		$id=UID;
    	}
    
    	// 获取详细数据
    	$Member = M('Member');
    	$data = $Member->where('uid='.$id)->find();
    	if(!$data){
    		$this->error($Member->getError());
    	}
    
    	$this->assign('data', $data);
    	//获取审核列表权限
    	$this->assign('show_examine', IS_ROOT || $this->checkRule('Admin/article/examine'));
 
    	$this->meta_title   =   '编辑个人资料';
    	$this->display();
    }
    
    /**
     * 文档编辑页面初始化
     * @author huajie <banhuajie@163.com>
     */
    public function editUid(){
    	 
    
    
        $id=UID;
    	
    
    	// 获取详细数据
    	$Member = M('Member');
    	$data = $Member->where('uid='.$id)->find();
    	if(!$data){
    		$this->error($Member->getError());
    	}
    
    	$this->assign('data', $data);
    
    	$this->meta_title   =   '编辑个人资料';
    	$this->display('editUid');
    }
    
    
    /**
     * 更新一条数据
     * @author huajie <banhuajie@163.com>
     */
    public function update(){
       $Member = M('Member');
       
       $uid = I('post.uid','');
       $bqname = I('post.bqname','');
       $email = I('post.email','');
       $bqarray =  explode("、",$bqname);
       $bqsize = count($bqarray);
       if($bqsize>3){
       	$this->error('标签不能大于三个！');
       }
       
       $nickname = I('post.nickname');
       
       empty($nickname) && $this->error('请输入昵称');
       empty($email) && $this->error('请输入邮箱');
       
       //密码验证
 
       
       $udata = array('username'=>$nickname,'email'=>$email);
       $Api    =   new UserApi();
       $status    =   $Api->updateInfoNopassword($uid, $udata);
       
       if($status){
       	$user               =   session('user_auth');
       	$user['username']   =   $nickname;
       	session('user_auth', $user);
       	session('user_auth_sign', data_auth_sign($user));   	
       }else{
       	$this->error('修改昵称失败！');
       }
       
       
        
        /* 获取数据对象 */
        $data = $Member->token(false)->create($data);
        if(empty($data['uid'])){
        	return false;
        }   
        $res = $Member->where('uid='.$data['uid'])->save($data);
        if(!$res){
            $this->error($Member->getError());
        }else{
        	$group  =   AuthGroupModel::getUserGroup(UID);
        	if($group[0]['group_id']==2){	 
        		 $this->success('更新成功', U('index'));
        	}else{
        		  $this->success('编辑成功！');
        	}
        	
           
        }
    }

    /**
     * 获取用户注册错误信息
     * @param  integer $code 错误编码
     * @return string        错误信息
     */
    private function showRegError($code = 0){
        switch ($code) {
            case -1:  $error = '用户名长度必须在16个字符以内！'; break;
            case -2:  $error = '用户名被禁止注册！'; break;
            case -3:  $error = '用户名被占用！'; break;
            case -4:  $error = '密码长度必须在6-30个字符之间！'; break;
            case -5:  $error = '邮箱格式不正确！'; break;
            case -6:  $error = '邮箱长度必须在1-32个字符之间！'; break;
            case -7:  $error = '邮箱被禁止注册！'; break;
            case -8:  $error = '邮箱被占用！'; break;
            case -9:  $error = '手机格式不正确！'; break;
            case -10: $error = '手机被禁止注册！'; break;
            case -11: $error = '手机号被占用！'; break;
            default:  $error = '未知错误';
        }
        return $error;
    }

}