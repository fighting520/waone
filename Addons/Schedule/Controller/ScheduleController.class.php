<?php

namespace Addons\Schedule\Controller;
use Home\Controller\AddonsController;

class ScheduleController extends AddonsController{
	
	//添加计划
	public function add(){
		if(IS_POST){
			$res = D('Addons://Schedule/Schedule')->addSchedule($_POST);
			if($res) {
				// TODO:记录日志
				$this->success('新增成功',U('addons/adminlist',array('name'=>Schedule)));
			} else {
				$this->error(L('新增失败'));
			}		 
		}else {
			$this->meta_title = '添加计划';
			$this->display(T('Addons://Schedule@Schedule/add'));			
		}
	}
	
	
	//修改计划
	public function update(){
		if(IS_POST){
			$res = D('Addons://Schedule/Schedule')->updateSchedule($_POST);
			if($res) {
				// TODO:记录日志
				$this->success('修改成功',U('addons/adminlist',array('name'=>Schedule)));
			} else {
				$this->error(L('修改失败'));
			}
		}else {
			$this->meta_title = '添加计划';
			$this->display(T('Addons://Schedule@Schedule/add'));
		}
	}
	
	
	//添加计划
	public function edit(){
		$id = I('param.id');
		if(empty($id)){
			$this->error("参数不能为空");
		}
		
		$data =  D('Addons://Schedule/Schedule')->where('id='.$id)->find();
		$this->assign("data",$data);
	    $this->meta_title = '编辑计划计划';
		$this->display(T('Addons://Schedule@Schedule/edit'));
	
	}
	
	//删除计划
	public function del(){
		if (!I('post.id')) {
			$this->error('请选择至少一条数据！');
		}
		$id = implode(I('post.id'), ',');
		if (D('Addons://Schedule/Schedule')->del($id)){
			$this->success('删除计划记录成功！');
		}else {
			$this->error('删除计划记录失败！');
		}		
	}
}
