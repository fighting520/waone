<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;

/**
 * 文档模型控制器
 * 文档模型列表和详情
 */
class AppmpController extends HomeController {


	/* 歌手列表 */
	public function listsinger($type=0){
	
		
		

		$Singer = D('Singer');
		if(empty($type)){
			$list = $Singer->select();
		}else{
			$list= $Singer->where('type=1')->select();
		}
		
		/* 返回JSON数据 */
		$this->ajaxReturn($list);
	}
	
	


	/* 歌手歌曲 */
	public function listmusic($scode = 0){
		$Music = D('Music');
		$condition['scode'] = $scode;
		$list =  $Music->where($condition)->select();
		
		$Singer = D('Singer');
		$ser = $Singer->field('singer,pimg')->where($condition)->find();
		foreach ($list as  $key=>$data){
			$data['singer'] = $ser['singer'];
			$data['pimg'] = $ser['pimg'];
			$list[$key] = $data;
		}
		
		$this->ajaxReturn($list);
	}
	
	

	/* 封面图片*/
	public function surface(){
		$data['url'] = C('SURFACE');
		
		$this->ajaxReturn($data);
	}
	
	function mp3_len() {
		
		$Music = D('Music');

		$list =  $Music->select();
		
		foreach ($list as $music){
			$url = $music['url'];
			$url =substr($url,-10,10);
			$handle = 'E:/Users/musicsource/maopai/music128/'.$url;
			$m = new \Org\Util\mp3file($handle);
			$a = $m->get_metadata();
		    $time =   $a['Length']*1000; 
		    $music['time'] =$time;
		    $Music->where('id='.$music['id'])->save($music);
		//	break;
		//echo $url;
	    }
	
	
	}
	
	

}
