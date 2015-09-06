<?php

/**
 * @description 音乐人音乐
 * @Author: lipeng
 * @CreateTime: 2015-07-28 09:51:06
 */
namespace Admin\Controller;
use Admin\Model\AuthGroupModel;

class MusicController extends AdminController {
	protected $Music;
	protected $Mdetail;
	public function _initialize() {
		parent::_initialize ();
		$this->Music = D('Common/Music');
		$this->Mdetail = D('Common/MusicDetail');
	}
	
	// 音乐人音乐 - 列表
	public function index() {
		
// 		$group  =   AuthGroupModel::getUserGroup(UID);
// 		if($group[0]['group_id']==2){
// 			$map['uid'] =UID;
// 		}
	//	echo date('YmdHis');
	
		 
		$songer = I('songer');
		if(!empty($songer)){
			$map['songer'] = array('like','%'.$songer.'%');
		}
		
		$songname = I('songname');
		if(!empty($songname)){
			$map['songname'] = array('like','%'.$songname.'%');
		}
		 
		 
		$del_flag = I('param.del_flag');
		if(empty($del_flag)){
			$del_flag=0;
		}
		
		if($del_flag!=10){
			$map['del_flag'] = $del_flag;
		}
		
		$mtype = I('param.mtype');
		if(!empty($mtype)){
			$map['mtype'] = $mtype;
		}else{
			$mtype=0;
		}
		 
		Cookie('__forward__',$_SERVER['REQUEST_URI']);
		
		$list = $this->lists ( $this->Music, $map, 'id desc', true );
			
		$this->assign ( 'list', $list );
		$this->assign ( 'del_flag', $del_flag );
		$this->assign ( 'mtype', $mtype );
		$this->assign ( 'meta_title', '音乐人音乐管理' );
		$this->display ();
	}
	
	// 音乐人音乐 - 查看
	public function form() {
		
		$id = I ( 'param.id' );
		if ($id) {
			
			$music =  $this->Music->find ($id);
			$detail  = $this->Mdetail->find($id);
			
			if($music['del_flag']!=0){
				$music['create_date'] = date("Y-m-d G:i:s");
			}
			
			
			if($detail){
				$info = array_merge($music,$detail);
			}else{
				$info = $music;
			}
			
			$this->assign ( 'info',$info);
			$this->assign ( 'meta_title', '编辑音乐人音乐' );
		} else {
			$this->assign ( 'meta_title', '添加音乐人音乐' );
		}
		$this->display ();
	}
	
	// 音乐人音乐 - 编辑
	public function save() {
		$songphoto = I ( 'param.songphoto' );
		if (empty ( $songphoto )) {
			$this->error ( "配图不能为空" );
		} else {
			$_POST ['thumbnail_url'] = D ( 'picture' )->getFieldByUrl ( $songphoto, 'thumbnail_url' );
		}
		$id = I ( 'param.id' );
		$reason = I('reason');
		
		if ($id) {
			//$_POST ['update_date'] = date("Y-m-d G:i:s");
			$date = date("Y-m-d G:i:s");
			
			
			$ystauts = $this->Music->getFieldById($id,'del_flag');
			$create_by = I('create_by');
			
			$status = I('del_flag');
			
			
			if($ystauts==2){
				if($status==0){
					//审核通过
				//	sendYesUserEmail($email, $name);
					 
				}else if($status==2){
					$create = D('Singer')->field('username,email')->where("uid=".$create_by)->find();
					$email = $create['email'];
					$reason = I('reason');
					$name = $create['username'];
					//驳回
				//	sendNoMusicEmail($email, $name, $reason);
					 
				}
			}
			$ypid =  I('ypid');
			if($ypid){
				$datayoup['status'] = 5;
				D('Youpin')->where('id='.$ypid)->save($datayoup);
			}
			
			if($reason){
				
				$data['id'] = $id;
				$data['auid'] = UID;
				$data['reason'] = $reason;
				$data['audit_time'] = NOW_TIME;
				$data['lyric'] = I('lyric');
				$did = $this->Mdetail->field('id')->find($id);
				if($did){
					$this->Mdetail->save($data);
				}else{
				  $this->Mdetail->add($data);
				}
			}
			unset($_POST ['reason']);
			unset($_POST ['lyric']);
			if ($this->Music->create() && $this->Music->save()) {
				
			} else {
			//	$this->error ( 'Err: ' . $this->Music->getError() );
				
			}
			$this->success ( '音乐更新成功',Cookie('__forward__') );
		} else {
			$_POST ['update_date'] = date("Y-m-d G:i:s");
			$_POST ['create_date'] = date("Y-m-d G:i:s");
			
			
			
			
			if ($this->Music->create()) {
				$id =  $this->Music->add();
				$data['id'] = $id;
				$data['lyric'] = I('lyric');
				$this->Mdetail->add($data);
			
			} else {
				$this->error ( 'Err: ' . $this->Music->getError() );
			}
			$this->success ( '音乐新增成功', Cookie('__forward__') );
		}
	}
	
	// 音乐人音乐 - 审核
	public function audit() {
		$songphoto = I ( 'param.songphoto' );
		if (empty ( $songphoto )) {
			$this->error ( "配图不能为空" );
		} else {
			$_POST ['thumbnail_url'] = D ( 'picture' )->getFieldByUrl ( $songphoto, 'thumbnail_url' );
		}
		
		$_POST ['update_date'] = NOW_TIME;
		$del_flag = I ( 'param.del_flag' );
		$reason = I ( 'param.reason' );
		
		if ($del_flag == 4) {
			// 发送验证邮箱
			$url = 'http://' . $_SERVER ['HTTP_HOST'];
			$content = "审核未通过 <br/>" . $url . "<br/>" . modC ( 'WEB_SITE_NAME', '音乐人开放平台', 'Config' ) . "系统自动发送--请勿直接回复<br/>" . date ( 'Y-m-d H:i:s', TIME () ) . "</p>";
			send_mail ( $email, modC ( 'WEB_SITE_NAME', '音乐人开放平台', 'Config' ) . "音乐审核未通过", $content );
		}
		
		if ($this->Music->create () && $this->Music->save ()) {
			if ($del_flag == 4) {
				$this->success ( '音乐人音乐驳回成功', U ( 'index' ) );
			} else if ($del_flag == 2) {
				$this->success ( '音乐人音乐更新成功', U ( 'index' ) );
			} else if ($del_flag == 1) {
				$this->success ( '音乐人音乐审核成功', U ( 'index' ) );
			}
		} else {
			$this->error ( 'Err: ' . $this->Music->getError() );
		}
	}
	
	//通过ID获取歌词
	public function findByIds() {
		$id =  I('id', 0);
		$map['id'] = $id;
		$info = $this->Mdetail->field('id,lyric')->where($map)->find();
		$this->ajaxReturn($info);
	}
	
	// 音乐人音乐 - 删除
	public function del() {
		$id = array_unique ( ( array ) I ( 'id', 0 ) );
		if (empty ( $id )) {
			$this->error ( '请选择要操作的数据!' );
		}
		$map = array (
				'id' => array (
						'in',
						$id 
				) 
		);
		$data = array (
				'del_flag' => '1' 
		);
		$this->Music->where ( $map )->save( $data );
		$this->success ( '音乐人音乐删除成功' );	
	}
}