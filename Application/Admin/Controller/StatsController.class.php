<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Controller;
use User\Api\UserApi;
use Admin\Model\AuthGroupModel;

/**
 * 后台统计控制器
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class StatsController extends AdminController {

    /**
     * 用户管理首页
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function index(){
    	
    	$Model = new \Think\Model(); // 实例化一个model对象 没有对应任何数据表
    	$sqlz = "select '0' as pid,a.rid as id,  a.rid,songname,songer,'all' as platform,sum(dits) as dits,sum(oits) as oits,sum(iits) as iits,sum(hits) as hits,sum(nhits) as nhits from tj_music a left join cms_resource b on a.rid = b.id  where 1=1  
    			  ";
    	$sqlx = "a.id,songname,songer,platform,sum(dits) as dits,sum(oits) as oits,sum(iits) as iits,sum(hits) as hits,sum(nhits) as nhits from tj_music a left join cms_resource b on a.rid = b.id  where 1=1 ";
    //	$rid       =   I('rid');		
    			
    //	$group = " group by rid";
    	$rid       =   I('rid');
    	if(!empty($rid)){
    		$sqlz .=" and rid = ".$rid;
    		$sqlx .=" and rid = ".$rid;
    	}
    	
    	$songname = I('songname');
    	if(!empty($songname)){
    		$sqlz .=" and songname like '%".$songname."%";
    		$sqlx .=" and songname like '%".$songname."%";
    	}
    	
    	$songer= I('songer');
    	if(!empty($songer)){
    		$sqlz .=" and songer like '%".$songer."%";
    		$sqlx .=" and songer like '%".$songer."%";
    	}
    	
    	$time_start = I('time_start');
    	$time_end = I('time_end');
    	if(!empty($time_start)&&!empty($time_end)){
    		$sqlz .=" and create_time between ".$time_start." and ".$time_end;
    		$sqlx .=" and create_time between ".$time_start." and ".$time_end;
    	}
    	
    	$sqlz .= "group by rid"; 
    	
    	$order = I('_order');
    	if(!empty($order)){
    		$sqlz .=$order;
    	//	$sqlx .=$order;
    	}else{
    		$sqlz .=" order by rid desc";
    	//	$sqlx .=" order by rid";
    	}
    	
    	$list =   $this->sqllists($sqlz);
    	$list2[0] = $list[0];
    	for ($i=0;$i<count($list);$i++ ) {
    		$data = $list[$i];
    		$sqldx = 'select a.rid as pid , '.$sqlx.'and a.rid = '.$data['rid'].' group by platform';
    		$listx =  $Model->query($sqldx);
    	//	if($i>0){
	    		$datalist[0] = $data;
	    		$list2 =array_merge($list2,$datalist);
    	//	}
    //	$list0[0] = $data;
    		$list2 = array_merge($list2,$listx);
    	}
    	
    	
    	array_shift($list2);
        $this->assign('_list', $list2);
        $this->meta_title = '音乐统计';
        $this->display();;
    }
    
    
    
    /**
     * 歌曲试听量
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function musicst(){
    	 
    	$Model = new \Think\Model(); // 实例化一个model对象 没有对应任何数据表
    	$sqlz = "select a.rid as id,  a.rid,songname,songer,sum(nhits) as nhits from tj_music a left join cms_resource b on a.rid = b.id  where 1=1 ";
     	$rid       =   I('rid');
    	if(!empty($rid)){
    		$sqlz .=" and rid = ".$rid;
    	}
    	 
    	$songname = I('songname');
    	if(!empty($songname)){
    		$sqlz .=" and songname like '%".$songname."%'";
    	}
    	 
    	$songer= I('songer');
    	if(!empty($songer)){
    		$sqlz .=" and songer like '%".$songer."%'";
    	}
    	 
    	$time_start = I('time_start');
    	$time_end = I('time_end');
    	if(!empty($time_start)&&!empty($time_end)){
    		$sqlz .=" and a.create_time between '".$time_start."' and '".$time_end."'";
    	}
    	 
    	$sqlz .= " group by a.rid  ";
    	 
    	$order = I('orderBy');
    	if(!empty($order)){
    		$sqlz .= 'order by '.$order;
    		
    	}else{
    		$sqlz .=" order by a.rid desc";
    	}
    	
    	
    	$list =   $this->sqllists($sqlz);
    
    	 
    	$this->assign('_list', $list);
    	$this->meta_title = '音乐统计';
    	$this->display();;
    }
    
    
    /**
     * 单曲试听量
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function dqmusic(){
    
    	$Model = new \Think\Model(); // 实例化一个model对象 没有对应任何数据表
    	$sqlz = "select a.rid as id,  a.rid,songname,songer, sum(nhits) as nhits,a.create_time from tj_music a left join cms_resource b on a.rid = b.id  where 1=1 ";
    	$rid       =   I('rid');
    	if(!empty($rid)){
    		$sqlz .=" and rid = ".$rid;
    	}
    
    	$songname = I('songname');
    	if(!empty($songname)){
    		$sqlz .=" and songname like '%".$songname."%'";
    	}
    
    	$songer= I('songer');
    	if(!empty($songer)){
    		$sqlz .=" and songer like '%".$songer."%'";
    	}
    
    	$time_start = I('time_start');
    	$time_end = I('time_end');
    	if(!empty($time_start)&&!empty($time_end)){
    		$sqlz .=" and a.create_time between '".$time_start."' and '".$time_end."'";
    	}
    	
    	$sqlz .= " group by a.rid,a.create_time ";
    
        $order = I('orderBy');
    	if(!empty($order)){
    		$sqlz .= ' order by '.$order;
    		
    	}else{
    		$sqlz .=" order by a.rid desc ";
    	}
    	
    	
    	$list =   $this->sqllists($sqlz);
    
    
    	$this->assign('_list', $list);
    	$this->meta_title = '单曲试听量统计';
    	$this->display();
    }
    
    
    /**
     * 乐人浏览量统计
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function yueren(){
    
    	$Model = new \Think\Model(); // 实例化一个model对象 没有对应任何数据表
    	$sqlz = "select a.did as id,  a.did,title, sum(a.view) as view,b.create_time from tj_document a left join wa_document b on a.did = b.id  where 1=1 and b.category_id = 543 and b.status = 1 ";
    	$id       =   I('id');
    	if(!empty($id)){
    		$sqlz .=" and did = ".$id;
    	}
    
    	$title = I('title');
    	if(!empty($title)){
    		$sqlz .=" and title like '%".$title."%'";
    	}
    
    	
    
    	$time_start = I('time_start');
    	$time_end = I('time_end');
    	
    	if(!empty($time_start)&&!empty($time_end)){
    		$sqlz .=" and b.create_time between '".  strtotime($time_start)."' and '". (strtotime($time_end)+60*60*24 - 1)."'";
    	}
    	 
    	$sqlz .= " group by a.did";
    
    	$order = I('orderBy');
    	if(!empty($order)){
    		$sqlz .= ' order by '.$order;
    
    	}else{
    		$sqlz .=" order by a.did desc ";
    	}
    	 
    	$list =   $this->sqllists($sqlz);
    
    
    	$this->assign('_list', $list);
    	$this->meta_title = '乐人浏览量';
    	$this->display();
    }
    
    
    
    /**
     * 公告浏览量统计
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function notice(){
    
    	
    	$sqlz = "select a.nid as id,title, sum(a.hits) as hits,b.create_time from oc_tjnotice a left join oc_notice b on a.nid = b.id  where 1=1  and b.status = 1 ";
    	$id       =   I('id');
    	if(!empty($id)){
    		$sqlz .=" and nid = ".$id;
    	}
    
    	$title = I('title');
    	if(!empty($title)){
    		$sqlz .=" and title like '%".$title."%'";
    	}
    
    	 
    
    	$time_start = I('time_start');
    	$time_end = I('time_end');
    	 
    	if(!empty($time_start)&&!empty($time_end)){
    		$sqlz .=" and b.create_time between '".  strtotime($time_start)."' and '". (strtotime($time_end)+60*60*24 - 1)."'";
    	}
    
    	$sqlz .= " group by a.nid";
    
    	$order = I('orderBy');
    	if(!empty($order)){
    		$sqlz .= ' order by '.$order;
    
    	}else{
    		$sqlz .=" order by a.nid desc ";
    	}
    
    	$list =   $this->sqllists($sqlz,'DB_CONFIG2');
    
    
    	$this->assign('_list', $list);
    	$this->meta_title = '公告浏览量';
    	$this->display();
    }
    
    
    /**
     * 广告浏览统计
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function adview(){
    
    	 
    	$sqlz = "select a.yid as id,title, sum(a.hits) as hits,b.create_time from oc_tjyoupin a left join oc_youpin b on a.yid = b.id  where 1=1  and status in (1,5)  ";
    	$id       =   I('id');
    	if(!empty($id)){
    		$sqlz .=" and a.yid = ".$id;
    	}
    
    	$title = I('title');
    	if(!empty($title)){
    		$sqlz .=" and title like '%".$title."%'";
    	}
    
    
    
    	$time_start = I('time_start');
    	$time_end = I('time_end');
    
    	if(!empty($time_start)&&!empty($time_end)){
    		$sqlz .=" and b.create_time between '".  strtotime($time_start)."' and '". (strtotime($time_end)+60*60*24 - 1)."'";
    	}
    
    	$sqlz .= " group by a.yid ";
    
    	$order = I('orderBy');
    	if(!empty($order)){
    		$sqlz .= ' order by '.$order;
    
    	}else{
    		$sqlz .=" order by a.yid desc ";
    	}
    
    	$list =   $this->sqllists($sqlz,'DB_CONFIG2');
    
    
    	$this->assign('_list', $list);
    	$this->meta_title = '广告浏览统计';
    	$this->display();
    }
    
    
    
    
    
    
  

}