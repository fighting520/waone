<?php

/**
 * @description 公告
 * @Author: lipeng
 * @CreateTime: 2015-08-11 16:02:05
 */
namespace Admin\Controller;

use Admin\Model\AuthGroupModel;

class NoticeController extends AdminController {
	protected $Notice;
	protected $Ndetail;
	public function _initialize() {
		parent::_initialize ();
		
		$this->Notice = D ( 'Notice' );
		$this->Ndetail = D ( 'NoticeDetail' );
	}
	
	// 公告 - 列表
	public function index() {
		$group = AuthGroupModel::getUserGroup ( UID );
		
		$status = I ( 'param.status' );
		if (empty ( $status )) {
			$status = 1;
		}
		if ($status != 10) {
			$map ['status'] = $status;
		}
		$title = I ( 'param.title' );
		if (! empty ( $title )) {
			$map ['title'] = array (
					'like',
					'%' . $title . '%' 
			);
		}
		
		$mtype = I ( 'param.mtype' );
		if (! empty ( $mtype )) {
			$map ['mtype'] = $mtype;
		} else {
			$mtype = 0;
		}
		Cookie('__forward__',$_SERVER['REQUEST_URI']);
		
		$list = $this->lists ( $this->Notice, $map, 'create_time desc', true );
		$this->assign ( 'list', $list );
		$this->assign ( 'mtype', $mtype );
		$this->assign ( 'status', $status );
		
		$this->assign ( 'meta_title', '公告管理' );
		$this->display ();
	}
	
	// 公告 - 查看
	public function form() {
		if (I ( 'param.id' )) {
			
			$ndetail = $this->Ndetail->find ( I ( 'param.id' ) );
			$notice = $this->Notice->find ( I ( 'param.id' ) );
			if ($notice ['status'] != 1) {
				$notice ['create_time'] = NOW_TIME;
			}
			
			$info = array_merge ( $notice, $ndetail );
			
			$this->assign ( 'info', $info );
			$this->assign ( 'meta_title', '编辑公告' );
		} else {
			$this->assign ( 'meta_title', '添加公告' );
		}
		$this->display ();
	}
	
	// 公告 - 编辑
	public function save() {
		$group = AuthGroupModel::getUserGroup ( UID );
		if ($group [0] ['group_id'] == 2 || IS_ROOT) {
			$_POST ['uid'] = 1;
		}
		
		$id = I ( 'param.id' );
		if ($id) {
			
			// $Music = D('Common/Music');
			// $gdlist = $Music->field('id')->where('ggid='.$id)->select();
			// if(!empty($gdlist)){
			// foreach ($gdlist as $gd){
			// $Music-> where('id='.$gd['id'])->setField('del_flag','2');
			// }
			// }
			
			$_POST ['update_time'] = NOW_TIME;
			$create_time = $_POST ['create_time'];
			$_POST ['create_time'] = strtotime ( $create_time );
			
			if ($this->Notice->create () && $this->Notice->save ()) {
			} else {
				// $this->error('Err: '.$this->Notice->getDbError());
			}
			
			if ($this->Ndetail->create () && $this->Ndetail->save ()) {
				// $this->success('公告更新成功',U('index'));
			} else {
				// $this->Notice->where('id='.I('param.id'))->delete();
				// $this->error('Err: '.$this->Ndetail->getError());
			}
			$this->success ( '公告更新成功', Cookie('__forward__') );
			
		} else {
			$_POST ['update_time'] = NOW_TIME;
			$_POST ['create_time'] = NOW_TIME;
			
			$_POST ['uid'] = 1;
			$_POST['mtype'] = 2;
			
			if ($this->Notice->create ()) {
				$id = $this->Notice->add ();
				// $this->success('公告更新成功',U('index'));
			} else {
				
				$this->error ( 'Err: ' . $this->Notice->getError () );
			}
			
			$_POST ['id'] = $id;
			
			if ($this->Ndetail->create () && $this->Ndetail->add ()) {
				$this->success ( '公告更新成功', Cookie('__forward__') );
			} else {
				$this->Notice->where ( 'id=' . I ( 'param.id' ) )->delete ();
				$this->error ( 'Err: ' . $this->Ndetail->getError () );
			}
		}
	}
	
	/**
	 * 公告选择列表
	 */
	function selectlist() {
		$group = AuthGroupModel::getUserGroup ( UID );
		
		$map ['status'] = 1;
		
		$title = I ( 'param.title' );
		if (! empty ( $title )) {
			$map ['title'] = array (
					'like',
					'%' . $title . '%' 
			);
		}
		
		$mtype = I ( 'param.mtype' );
		if (! empty ( $mtype )) {
			$map ['mtype'] = $mtype;
		} else {
			$mtype = 0;
		}
		
		$list = $this->lists ( $this->Notice, $map, 'create_time desc', true );
		$this->assign ( 'list', $list );
		$this->assign ( 'status', $status );
		$this->assign ( 'mtype', $mtype );
		$this->assign ( 'meta_title', '公告管理' );
		$this->display ( 'selectList' );
	}
	
	// 通过ID获取列表
	public function findByIds() {
		$id = array_unique ( ( array ) I ( 'ids', 0 ) );
		$map = array (
				'id' => array (
						'in',
						$id 
				) 
		);
		$info = $this->Notice->field ( 'id,title' )->where ( $map )->select ();
		$this->ajaxReturn ( $info );
	}
	
	// 公告 - 删除
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
		$data ['status'] = 0;
		$this->Notice->where ( $map )->save ( $data );
		$this->success ( '公告删除成功', U ( 'index' ) );
	}
}