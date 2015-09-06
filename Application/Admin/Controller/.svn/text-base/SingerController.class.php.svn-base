<?php
/**
 * @description 音乐人
 * @Author: lipeng
 * @CreateTime: 2015-08-21 11:44:01
 */

namespace Admin\Controller;

class SingerController extends AdminController{

    protected $Singer;
    protected $Sdetail;

    public function _initialize(){
        parent::_initialize();
        $this->Singer=D('Singer');
        $this->Sdetail=D('SingerDetail');
    }

    // 音乐人 - 列表
    public function index(){
    	
    	
    	$uid = I('param.uid');
    	if(!empty($uid)){
    		$map['uid'] = $uid;
    	}
    	 
    	 
    	 
    	$status = I('param.status');
    	if(empty($status)){
    		$status = 1;
    	}
    	 
    	$map['status'] = $status;
    	
        $list=$this->lists($this->Singer,$map,'uid desc',true);
        $size = count($list);
        $ldata = array();
        for ($i=0;$i<$size;$i++){
        	$data = $list[$i];
        	$detail = $this->Sdetail->find($data['uid']);
        	if($detail){
        		unset($detail ['uid']);
        		$data = array_merge($data,$detail);
        	}
        	array_push($ldata,$data);
        	
        }
        $this->assign('list',$ldata);
        $this->assign('status',$status);
        $this->assign('meta_title','音乐人管理');
        $this->display();
    }

    // 音乐人 - 查看
    public function form(){
    	$id = I('param.id');
        if($id){       	
        	
        	$singer = $this->Singer->find($id);
        	$detail = $this->Sdetail->find($id);
        	unset($detail ['uid']);
        	$info = array_merge($singer,$detail);
            $this->assign('info',$info);
                       
            $this->assign('meta_title','编辑音乐人');
     
        }
        else{
            $this->assign('meta_title','添加音乐人');
            
        }
        $this->display();
    }

    // 音乐人 - 编辑
    public function save(){
    	$uid = I('uid');
        if($uid){
        	
        	$ystauts = $this->Singer->getFieldByUid($uid,'status');	
        	$status = I('status');
        	$email = I('email');
        	$name = I('name');
        	$reason = I('reason');        	
        	
            if($this->Singer->create() && $this->Singer->save()){
             //   $this->success('音乐人更新成功',U('index'));
            }
            else{
            //    $this->error('Err: '.$this->Singer->getError());
            }
            
            if($this->Sdetail->create() && $this->Sdetail->save()){
            	//   $this->success('音乐人更新成功',U('index'));
            }
            else{
          //  	$this->error('Err: '.$this->Sdetail->getError());
            }
            if($ystauts!=1){
            	if($status==1){
            		//审核通过
            		sendYesUserEmail($email, $name);
            		 
            	}else if($status==4){
            		//驳回
            		sendNoUserEmail($email, $uid, $name, $reason);
            		 
            	}
            }
            
            $this->success('审核成功，邮件已发送',U('index'));
            
            
        } else{
            $_POST['update_date'] = NOW_TIME;
            $_POST['create_date'] = NOW_TIME;
            if($this->Singer->create() && $this->Singer->add()){
                $this->success('音乐人更新成功',U('index'));
            }
            else{
                $this->error('Err: '.$this->Singer->getError());
            }
        }
    }

    // 音乐人 - 删除
    public function del(){
        $id = array_unique((array) I('id', 0));
        if (empty($id)) {
            $this->error('请选择要操作的数据!');
        }
        $map = array('id' => array('in', $id));
        $data = array (
        		'status' => '0'
        );
        if ($this->Singer->where($map)->save($data)) {
            $this->success('音乐人删除成功');
        } else {
            $this->error('音乐人删除失败！' . $this->{__MODULE_NAME__}->getLastSql());
        }
    }
}