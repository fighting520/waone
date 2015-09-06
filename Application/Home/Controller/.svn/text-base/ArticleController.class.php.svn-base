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
class ArticleController extends HomeController {

    /* 文档模型频道页 */
	public function index(){
		/* 分类信息 */
		$category = $this->category();

		//频道页只显示模板，默认不读取任何内容
		//内容可以通过模板标签自行定制

		/* 模板赋值并渲染模板 */
		$this->assign('category', $category);
		$this->display($category['template_index']);
	}

	/* 文档模型列表页 */
	public function lists($p = 1){
		/* 分类信息 */
		$category = $this->category();

		/* 获取当前分类列表 */
		$Document = D('Document');
		$list = $Document->page($p, $category['list_row'])->lists($category['id']);
		if(false === $list){
			$this->error('获取列表数据失败！');
		}

		/* 模板赋值并渲染模板 */
		$this->assign('category', $category);
		$this->assign('list', $list);
		$this->display($category['template_lists']);
	}

	/* 文档模型详情页 */
	public function detail($id = 0, $p = 1){
		/* 标识正确性检测 */
		if(!($id && is_numeric($id))){
			$this->error('文档ID错误！');
		}

		/* 页码检测 */
		$p = intval($p);
		$p = empty($p) ? 1 : $p;

		/* 获取详细信息 */
		$Document = D('Document');
		$info = $Document->detail($id);
		if(!$info){
			$this->error($Document->getError());
		}

		/* 分类信息 */
		$category = $this->category($info['category_id']);

		/* 获取模板 */
		if(!empty($info['template'])){//已定制模板
			$tmpl = $info['template'];
		} elseif (!empty($category['template_detail'])){ //分类已定制模板
			$tmpl = $category['template_detail'];
		} else { //使用默认模板
			$tmpl = 'Article/'. get_document_model($info['model_id'],'name') .'/detail';
		}

		/* 更新浏览数 */
		$map = array('id' => $id);
		$Document->where($map)->setInc('view');

		/* 模板赋值并渲染模板 */
		$this->assign('category', $category);
		$this->assign('info', $info);
		$this->assign('page', $p); //页码
		$this->display($tmpl);
	}

	/* 文档分类检测 */
	private function category($id = 0){
		/* 标识正确性检测 */
		$id = $id ? $id : I('get.category', 0);
		if(empty($id)){
			$this->error('没有指定文档分类！');
		}

		/* 获取分类信息 */
		$category = D('Category')->info($id);
		if($category && 1 == $category['status']){
			switch ($category['display']) {
				case 0:
					$this->error('该分类禁止显示！');
					break;
				//TODO: 更多分类显示状态判断
				default:
					return $category;
			}
		} else {
			$this->error('分类不存在或被禁用！');
		}
	}
	
	
	/**
	 * 文档编辑页面初始化
	 * @author huajie <banhuajie@163.com>
	 */
	public function view(){
		 
		$id     =   I('get.id','');
		 
		//  	$viewtype = I('get.viewtype','');
		 
		 
		 
		 
	
	
		if(empty($id)){
			$this->error('参数不能为空！');
		}
	
		// 获取详细数据
		$Document = D('Document');
		$data = $Document->detail($id);
		if(!$data){
			$this->error($Document->getError());
		}
		$article['id'] =$data['id'];
		$article['title'] = $data['title'];
		$article['image'] = $data['cover_url'];
		 
		$article['description'] = $data['description'];
		$article['hits'] = $data['view'];
		$article['isshare'] = "3";
		$article['zits'] = $data['zits'];
		$article['isdz'] = "0";
		$article['cits'] = $data['comment'];
		$article['sits'] = $data['sits'];
		$article['status'] = $data['status'];
		 
		$article['category'] = D('Category')->field('id,title as name ')->find($data['category_id']);
		 
		$article['createDate'] = date("Y-m-j H:i:s",$data['create_time']);
		$article['updateDate'] = date("Y-m-j H:i:s",$data['update_time']);
		 
		$article['createBy'] = D('Member')->find($data['uid']);
		$article['bqname'] = $data['bsname'].split("、");
		 
	//	echo($article['bqname'][0]);
		/* 获取模型数据 */
		$logic  = logic($data['model_id']);
		$detail = $logic->detail($id); //获取指定ID的数据
		 
		if($data['category_id']==30){
			$article['apptype'] = $detail['apptype'];
			$article['amarket'] = $detail['amarket'];
			$article['asize'] = $detail['asize'];
			$article['alink'] = $detail['alink'];
			$article['imarket'] = $detail['imarket'];
			$article['ilink'] = $detail['ilink'];
			$article['isize'] = $detail['isize'];
			$article['isshow'] = $detail['isshow'];
		}elseif($data['category_id']==650){
			$article['youpintype'] = $detail['youpintype'];
			$detail['price'] = (float) $detail['price'];
			$article['link'] = $detail['gmlink'];
			$article['isshow'] = $detail['isshow'];
		}elseif($data['category_id']==543){
			if($detail['musiccode']){
				$detail['resource']  =	D('Resource')->where('resourcecode='.$detail['musiccode'])->find();
			}
		}
		 
		$article['articleData'] = $detail;
		 
		$return[0] = $article;
		$this->ajaxReturn($return,'JSONP');
	}

}
