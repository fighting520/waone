<?php
/**
 * @description 有品
 * @Author: lipeng
 * @CreateTime: 2015-08-11 16:01:28
 */

namespace Admin\Controller;
use Admin\Model\AuthGroupModel;

class YoupinController extends AdminController{

    protected $Youpin;
    protected $Ydetail;

    public function _initialize(){
        parent::_initialize();
        $this->Youpin=D('Common/youpin');
        $this->Ydetail=D('Common/youpinDetail');
    }

    // 有品 - 列表
    public function index(){
    	
    	$group  =   AuthGroupModel::getUserGroup(UID);
    	
    	
    	$id = I('param.id');
    	if(!empty($id)){
    		$map['id'] = $id;
    	}
    	
    	$title = I('param.title');
    	if(!empty($title)){
    		$map['title'] = array('like','%'.$title.'%');
    	}
    	
    	
    	$status = I('param.status');
    	if(empty($status)){
    		$status = 1;
    	}
    	
    	if($status!=10){
    		$map['status'] = $status;
    	}
    	
    	$mtype = I('param.mtype');
    	if(!empty($mtype)){
    		$map['mtype'] = $mtype;
    	}else{
    		$mtype=0;
    	}
        $list=$this->lists($this->Youpin,$map,'create_time desc',true);
        Cookie('__forward__',$_SERVER['REQUEST_URI']);
       
        $this->assign('list',$list);
        $this->assign('status',$status);
        $this->assign ( 'mtype', $mtype );
        $this->assign('meta_title','广告管理');
        $this->display();
    }

    // 有品 - 查看
    public function form(){
        if(I('param.id')){
        	
        	$ydetail =   $this->Ydetail->find(I('param.id'));
        	$youpin =  $this->Youpin->find(I('param.id'));
        	
        	if($youpin['status']!=1){
        		$youpin['create_time']=NOW_TIME;
        	}
        	
        	$info = array_merge($ydetail,$youpin);
        	
            $this->assign('info',$info);
            $this->assign('meta_title','编辑广告');
        }
        else{
            $this->assign('meta_title','添加广告');
       
        }
        $this->display();
    }

    // 有品 - 编辑
    public function save(){
        if(I('param.id')){
            $_POST['update_time'] = NOW_TIME;
            
            $create_time =  $_POST['create_time'];
            $_POST['create_time'] = strtotime($create_time);
            
            
            if($this->Youpin->create() && $this->Youpin->save()){
            }
            else{
          //      $this->error('Err: '.$this->Youpin->getError());
            }
            
         
            
            if($this->Ydetail->create()){
            //	$this->success('广告更新成功',U('index'));
            	$this->Ydetail->save();
            }else{
            
           // 	$this->error('Err: '.$this->Ydetail->getDbError());
            }
           
            $this->success('广告更新成功',Cookie('__forward__'));
        } else{
            $_POST['update_time'] = NOW_TIME;
            $_POST['create_time'] = NOW_TIME;
            
            $_POST['uid'] = 1;
            $_POST['mtype'] = 2;
            
            if($this->Youpin->create()  ){
            	$id = $this->Youpin->add();
            }
            else{
            	$this->error('Err: '.$this->Youpin->getError());
            }
            
            $_POST['id'] = $id;
            
            if($this->Ydetail->create()&& $this->Ydetail->add()){
            	
            	$this->success('广告新增成功',Cookie('__forward__'));
            	
            }
            else{
            	$this->Youpin->where('id='.I('param.id'))->delete();
            	$this->error('Err: '.$this->Ydetail->getError());
            }
            
           
            
          
        }
    }
    
    /**
     * 广告选择列表
     */
    function  selectlist() {
    	
    	$id = I('param.id');
    	if(!empty($id)){
    		$map['id'] = $id;
    	}
    	 
    	$title = I('param.title');
    	if(!empty($title)){
    		$map['title'] = array('like','%'.$title.'%');
    	}
    	 
    	 
    
    	$map['status'] = 1;
    	
    	$mtype = I('param.mtype');
    	if(!empty($mtype)){
    		$map['mtype'] = $mtype;
    	}else{
    		$mtype=0;
    	}
    	
    	 
    	
    	$list=$this->lists($this->Youpin,$map,'create_time desc',true);
    	$this->assign('list',$list);
    	$this->assign ( 'mtype', $mtype );
    	$this->assign('meta_title','广告管理');
    	$this->display('selectList');
    }
    
    
    //通过ID获取列表
    public function findByIds() {
    	$id = array_unique((array) I('ids', 0));
    	$map = array('id' => array('in', $id));
    	$info = $this->Youpin->field('id,title')->where($map)->select();
    	$this->ajaxReturn($info);
    }
    
    

    // 有品 - 删除
    public function del(){
        $id = array_unique((array) I('id', 0));
        if (empty($id)) {
            $this->error('请选择要操作的数据!');
        }
        $map = array('id' => array('in', $id));
        $data = array('status'=>0);
        $this->Youpin->where($map)->save($data);
        $this->success('广告删除成功');
       
    }
    
    
 	
    
    
    
    
    
}