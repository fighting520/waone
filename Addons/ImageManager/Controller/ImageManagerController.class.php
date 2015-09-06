<?php
namespace Addons\ImageManager\Controller;
use Admin\Controller\AddonsController;
use Admin\Model\AuthGroupModel;

class ImageManagerController extends AddonsController{
	public function ImageManager(){
            $name          = I("name");
            $callback = I("CKEditorFuncNum","0");
            $viewtype = I("viewtype");
            $id            = I("id");
            $times         = I("times", 0, "intval");
            $where         = array();
            if (!empty($times)) {
                $where = $this->getTimeMap($times);
            }
            $group  =   AuthGroupModel::getUserGroup(UID);
            if($group[0]['group_id']==2||IS_ROOT){
            	//      			             if(empty($data['uid'])){
            	//      		             			$data['uid'] = $data['category_id'];
            	//      			            }
            }else{
            	   $where['uid'] = UID;
            }
         
            
            $strTimes      = $this->getPictureTimes();
            $PictureResult = $this->getAllPictureData($where);
            //var_dump($PictureResult);die;
            
            $this->assign("addon_path", "./Addons/ImageManager/");
            $this->assign("curtime",    $times);
            $this->assign("strTimes",   $strTimes);
            $this->assign("name",       $name);
            $this->assign("callback",   $callback);
            $this->assign("viewtype",   $viewtype);
            $this->assign("id",         $id);
            $this->assign("_list",      $PictureResult);
            
            $this->display(T('Addons://ImageManager@ImageManager/index'));
	}
        
        /**
         * 
         * @return type
         */
        private function getAllPictureData (array $where = array()) {
            $result = M("Picture")->where($where)->where("status=1")->order('id desc')->select();
            return $result;
        }
        
        /**
         * 获取所有图片上传时间去重复
         * @param string $format    时间格式
         * @return array
         */
        private function getPictureTimes ($format = "Y年m月") {
            $times = M("Picture")->field("create_time")->select();
            $strTimes = array();
            foreach ($times as $time) {
               $strTimes[$time['create_time']] = date($format, $time['create_time']); 
            }
            return array_unique($strTimes);
        }
        
        private function getTimeMap ($time) {
            $start_time = strtotime(date("Y-m-1 00:00:00", $time));
            $end_time   = strtotime(date("Y-m-t 23:59:59", $time));
            $where['create_time'] = array("BETWEEN", array($start_time, $end_time));
            return $where;
        }
}
