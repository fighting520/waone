<?php
/**
 * @description {__CONTROLLER_DESCRIPTION__}
 * @Author: {__AUTHOR_DESCRIPTION__}
 * @CreateTime: {__CREATE_TIME__}
 */

namespace Admin\Controller;

class {__CONTROLLER_NAME__}Controller extends AdminController{

    protected ${__MODEL_NAME__};

    public function _initialize(){
        parent::_initialize();
        $this->{__MODEL_NAME__}=D('{__TABLE_NAME__}');
    }

    // {__CONTROLLER_DESCRIPTION__} - 列表
    public function index(){
        $list=$this->lists($this->{__MODEL_NAME__},null,'create_time desc',true);
        $this->assign('list',$list);
        $this->assign('meta_title','{__CONTROLLER_DESCRIPTION__}管理');
        $this->display();
    }

    // {__CONTROLLER_DESCRIPTION__} - 查看
    public function form(){
        if(I('param.id')){
            $this->assign('info',$this->{__MODEL_NAME__}->find(I('param.id')));
            $this->assign('meta_title','编辑{__CONTROLLER_DESCRIPTION__}');
     
        }
        else{
            $this->assign('meta_title','添加{__CONTROLLER_DESCRIPTION__}');
            
        }
        $this->display();
    }

    // {__CONTROLLER_DESCRIPTION__} - 编辑
    public function save(){
        if(I('param.id')){
            $_POST['update_date'] = NOW_TIME;
            if($this->{__MODEL_NAME__}->create() && $this->{__MODEL_NAME__}->save()){
                $this->success('{__CONTROLLER_DESCRIPTION__}更新成功',U('index'));
            }
            else{
                $this->error('Err: '.$this->{__MODEL_NAME__}->getDbError());
            }
        } else{
            $_POST['update_date'] = NOW_TIME;
            $_POST['create_date'] = NOW_TIME;
            if($this->{__MODEL_NAME__}->create() && $this->{__MODEL_NAME__}->add()){
                $this->success('{__CONTROLLER_DESCRIPTION__}更新成功',U('index'));
            }
            else{
                $this->error('Err: '.$this->{__MODEL_NAME__}->getDbError());
            }
        }
    }

    // {__CONTROLLER_DESCRIPTION__} - 删除
    public function del(){
        $id = array_unique((array) I('id', 0));
        if (empty($id)) {
            $this->error('请选择要操作的数据!');
        }

        $map = array('id' => array('in', $id));
        if ($this->{__MODEL_NAME__}->where($map)->delete()) {
            $this->success('{__CONTROLLER_DESCRIPTION__}删除成功');
        } else {
            $this->error('{__CONTROLLER_DESCRIPTION__}删除失败！' . $this->{__MODULE_NAME__}->getLastSql());
        }
    }
}