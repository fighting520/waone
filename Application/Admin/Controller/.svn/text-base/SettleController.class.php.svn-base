<?php
/**
 * @description 结算
 * @Author: lipeng
 * @CreateTime: 2015-08-21 10:41:11
 */

namespace Admin\Controller;

class SettleController extends AdminController{

    protected $Settle;

    public function _initialize(){
        parent::_initialize();
        $this->Settle=D('settle');
    }

    // 结算 - 列表
    public function index(){
        $list=$this->lists($this->Settle,null,'create_time desc',true);
        $this->assign('list',$list);
        $this->assign('meta_title','结算管理');
        $this->display();
    }

    // 结算 - 查看
    public function form(){
        if(I('param.id')){
            $this->assign('info',$this->Settle->find(I('param.id')));
            $this->assign('meta_title','编辑结算');
     
        }
        else{
            $this->assign('meta_title','添加结算');
            
        }
        $this->display();
    }

    // 结算 - 编辑
    public function save(){
        if(I('param.id')){
            $_POST['update_date'] = NOW_TIME;
            if($this->Settle->create() && $this->Settle->save()){
                $this->success('结算更新成功',U('index'));
            }
            else{
                $this->error('Err: '.$this->Settle->getDbError());
            }
        } else{
            $_POST['update_date'] = NOW_TIME;
            $_POST['create_date'] = NOW_TIME;
            if($this->Settle->create() && $this->Settle->add()){
                $this->success('结算更新成功',U('index'));
            }
            else{
                $this->error('Err: '.$this->Settle->getDbError());
            }
        }
    }

    // 结算 - 删除
    public function del(){
        $id = array_unique((array) I('id', 0));
        if (empty($id)) {
            $this->error('请选择要操作的数据!');
        }

        $map = array('id' => array('in', $id));
        if ($this->Settle->where($map)->delete()) {
            $this->success('结算删除成功');
        } else {
            $this->error('结算删除失败！' . $this->{__MODULE_NAME__}->getLastSql());
        }
    }
}