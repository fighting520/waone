<?php

namespace Addons\Schedule\Model;
use Think\Model;

/**
 * 用户服务
 * by iszhang
 */
class UserServiceModel extends Model{
	
	//用户服务状态
	public function doChageStatus(){
		// 获取用户服务列表
		$list = M('mservice_list')->where($map)->order('sid')->field('sid,stype,uid,etime,feed_email_time,jwid')->select();
		//当前时间
		$time = $_SERVER['REQUEST_TIME'];
		//获取提前通知的时间
		$pt = M('mproduct_type')->cache('cache_ptname',3600)->field('ptconfig')->where(array('ptid'=>4))->find();
		$ptdata = $this->object_array(json_decode($pt['ptconfig']));

		foreach ($list as $v) {
			// 更新最新检查邮件时间
			M('mservice_list')->where(array('sid'=>$v['sid']))->save(array('feed_email_time'=>time()));
			
			// 邮件频率判断
			
			//获取当前到期时间距离现在的天数
			$nowday = round(($v['etime'] - $time)/3600/24);
			
			if($v['etime'] < $time){
				//修改服务状态
				M('mservice_list')->where(array('sid'=>$v['sid']))->save(array('sstatus'=>'4'));
				if($v['jwid']){
					//修改机位状态
					M('mjiwei')->where(array('id'=>$v['jwid']))->save(array('status'=>'5'));	
				}
			}
			else if($nowday > 0 && $nowday < $ptdata[noticedays]){
				M('mservice_list')->where(array('sid'=>$v['sid']))->save(array('sstatus'=>'3'));	
			}
			
			
		}
	}
	
	//用户服务状态
	public function updateIp(){
		$query = "update wa_document set cover_url = replace(cover_url,'119.29.66.49','fast.wawa.fm') ;
update wa_document_app set content = replace(content,'119.29.66.49','fast.wawa.fm'),adimg = replace(adimg,'119.29.66.49','fast.wawa.fm'),codepic = replace(codepic,'119.29.66.49','fast.wawa.fm')  ;
update wa_document_wenyi set content = replace(content,'119.29.66.49','fast.wawa.fm'),adimg = replace(adimg,'119.29.66.49','fast.wawa.fm'),codepic = replace(codepic,'119.29.66.49','fast.wawa.fm')  ;
update wa_document_youpin set content = replace(content,'119.29.66.49','fast.wawa.fm'),adimg = replace(adimg,'119.29.66.49','fast.wawa.fm'),codepic = replace(codepic,'119.29.66.49','fast.wawa.fm')  ;
update wa_document_yueren set content = replace(content,'119.29.66.49','fast.wawa.fm'),adimg = replace(adimg,'119.29.66.49','fast.wawa.fm'),codepic = replace(codepic,'119.29.66.49','fast.wawa.fm')  ;
update wa_ucenter_member set pimg = replace(pimg,'119.29.66.49','fast.wawa.fm'),card = replace(card,'119.29.66.49','fast.wawa.fm') ;
update wa_member set pimg = replace(pimg,'119.29.66.49','fast.wawa.fm'),card = replace(card,'119.29.66.49','fast.wawa.fm')  ;
	";
		$res = M('')->execute($query);
		//  }
		if($res === false) {
			$error[] = array(
					'error_code' => M('')->getDbError(),
					'error_sql'  => $query,
			);
		
			if($stop) return $error[0];
		}
	}
	
	
	
	
 	private function object_array($array){
	  	if(is_object($array)){
	    	$array = (array)$array;
	  	}
	  	if(is_array($array)){
	    	foreach($array as $key=>$value){
	      		$array[$key] = $this->object_array($value);
	    	}
	  	}
	  return $array;
	} 	
}
