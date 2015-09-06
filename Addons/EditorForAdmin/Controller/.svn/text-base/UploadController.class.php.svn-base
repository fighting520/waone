<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: huajie <banhuajie@163.com>
// +----------------------------------------------------------------------

namespace Addons\EditorForAdmin\Controller;
use Home\Controller\AddonsController;
use Think\Upload;

class UploadController extends AddonsController{

	public $uploader = null;

	/* 上传图片 */
	public function upload(){
		session('upload_error', null);
		/* 上传配置 */
		$setting = C('EDITOR_UPLOAD');

		/* 调用文件上传组件上传文件 */
		$this->uploader = new Upload($setting, 'Local');
		$info   = $this->uploader->upload($_FILES);
		if($info){
			$url = C('EDITOR_UPLOAD.rootPath').$info['imgFile']['savepath'].$info['imgFile']['savename'];
			$url = str_replace('./', '/', $url);
			$info['fullpath'] = __ROOT__.$url;
		}
		session('upload_error', $this->uploader->getError());
		return $info;
	}

	//keditor编辑器上传图片处理
	public function ke_upimg(){
		/* 返回标准数据 */
		$return  = array('error' => 0, 'info' => '上传成功', 'data' => '');
		$img = $this->upload();
		/* 记录附件信息 */
		if($img){
			$return['url'] = $img['fullpath'];
			unset($return['info'], $return['data']);
		} else {
			$return['error'] = 1;
			$return['message']   = session('upload_error');
		}

		/* 返回JSON数据 */
		exit(json_encode($return));
	}

	/**
	 * 上传图片
	 * @author huajie <banhuajie@163.com>
	 */
	public function uploadPicture(){
		//TODO: 用户登录检测
	
	
	
		/* 调用文件上传组件上传文件 */
		$Picture = new \Admin\Model\PictureModel();;
		$pic_driver = C('PICTURE_UPLOAD_DRIVER');
		$info = $Picture->upload(
				$_FILES,
				C('PICTURE_UPLOAD'),
				C('PICTURE_UPLOAD_DRIVER'),
				//     C("UPLOAD_{$pic_driver}_CONFIG")
				C("PFASTDFS_UPLOAD")
		); //TODO:上传到远程服务器
	
		return $info;
	}

	//ueditor编辑器上传图片处理
	public function ue_upimg(){

		$img = $this->uploadPicture();
		$return = array();
		$return['url'] = $img['imgFile']['url'];
		$title = htmlspecialchars($_POST['pictitle'], ENT_QUOTES);
		$return['title'] = $title;
		$return['original'] = $img['imgFile']['name'];
		$return['state'] = ($img)? 'SUCCESS' : session('upload_error');
		/* 返回JSON数据 */
		$this->ajaxReturn($return);
	}
	
	
	//ckeditor编辑器上传图片处理
	public function ck_upimg(){
	
		$img = $this->uploadPicture();
		$return = array();
		$return['url'] = $img['upload']['url'];
		$title = htmlspecialchars($_POST['pictitle'], ENT_QUOTES);
		$return['title'] = $title;
		$return['original'] = $img['upload']['name'];
		$return['state'] = ($img)? 'SUCCESS' : session('upload_error');
	
		
		
		
		/* 返回JSON数据 */
		 $callback = $_REQUEST["CKEditorFuncNum"];  
		 $previewname = $img['upload']['url'];
		 $content = "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($callback,'".$previewname."','');</script>";
		echo $content;
	}

}
