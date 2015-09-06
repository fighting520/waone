<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

/**
 * 后台公共文件
 * 主要定义后台公共函数库
 * 
 */

//资料审核未通过

  function sendNoUserEmail($account, $uid,$username,$reason){

	$url = "http://open.wawa.fm/index.php?s=/Ucenter/Member/info.html&uid=".$uid."&reason=".$reason."&username=".$username;
	$content = '<p>{$username}：</p>

<p>很抱歉，您在挖哇音乐人平台填写的资料未通过审核，原因是：<br />
{$content}</p>

<p>请登录{$url}重新填写，感谢您的支持。</p>

<p>--------------------------------------------------------------------------------<br />
该邮件由挖哇音乐平台系统发出，请不要回复。<br />
如有任何疑问或建议，请登录http://open.wawa.fm/ 获取帮助</p>

<p>挖哇 - 音乐不止如此&nbsp;</p>';
	 
	$content = str_replace('{$url}', $url, $content);
	$content = str_replace('{$username}', $username, $content);
	$content = str_replace('{$content}', $reason, $content);
	 
	$res = sendmail($account, "挖哇音乐人平台资料审核信", $content);


	return $res;
}


//音乐审核未通过
 function sendNoMusicEmail($account,$username,$reason)
{

	$url = "http://open.wawa.fm/";
	$content = '<p>{$username}：</p>

<p>很抱歉，您在挖哇音乐人平台上传的音乐未通过审核，原因是：<br />
{$content}</p>

<p>请登录{$url}重新填写，感谢您的支持。</p>

<p>--------------------------------------------------------------------------------<br />
该邮件由挖哇音乐平台系统发出，请不要回复。<br />
如有任何疑问或建议，请登录http://open.wawa.fm/ 获取帮助</p>

<p>挖哇 - 音乐不止如此&nbsp;</p>';

	$content = str_replace('{$url}', $url, $content);
	$content = str_replace('{$username}', $username, $content);
	$content = str_replace('{$content}', $reason, $content);

	$res = sendmail($account, "挖哇音乐人平台音乐审核信", $content);


	return $res;
}




//资料审核通过
 function sendYesUserEmail($account,$username)
{

	$url = "http://open.wawa.fm/";
	$content = '<p>{$username}：</p>

<p>恭喜您，您在挖哇音乐人平台填写的资料通过审核，<br />
<p>登录地址{$url}，感谢您的支持。</p>
<p>--------------------------------------------------------------------------------<br />
该邮件由挖哇音乐平台系统发出，请不要回复。<br />
如有任何疑问或建议，请登录http://open.wawa.fm/ 获取帮助</p>

<p>挖哇 - 音乐不止如此&nbsp;</p>';

	$content = str_replace('{$url}', $url, $content);
	$content = str_replace('{$username}', $username, $content);

	$res = sendmail($account, "挖哇音乐人平台资料审核信", $content);


	return $res;
}



//获取字典数据
function get_ocusername($id) {
	$Dicts = D ( 'Common/Ocuserdetail' );
	$map ['uid'] = $id;
	$map ['status'] = '1';
	$data = $Dicts->field ('name')->where ($map)->find();
	return $data['name'];
}


//获取字典数据
function parse_dict_attr($string) {
	$Dicts = D ( 'Common/Dicts' );
	$map ['type'] = $string;
	$map ['status'] = '1';
	$data = $Dicts->field ( 'label,value' )->where ( $map )->select ();
	return $data;
}


//获取字典值
function get_dict_attr($type,$value) {
	$Dicts = D ( 'Common/Dicts' );
	$map ['type'] = $type;
	$map ['status'] = '1';
	$map ['value'] = $value;
	$data = $Dicts->field ( 'label' )->where ( $map )->find();
	return $data['label'];
}


//获取音乐时长
function  getMusictime($url){
	$handle = 'E:/Users/musicsource/maopai/music128/'.$url;
	$m = new \Org\Util\mp3file($handle);
	$a = $m->get_metadata();
	$time =   $a['Length']*1000;
	$music['time'] =$time;
}

/* 解析列表定义规则*/

function get_list_field($data, $grid){

    // 获取当前字段数据
    foreach($grid['field'] as $field){
        $array  =   explode('|',$field);
        $temp  =    $data[$array[0]];
        // 函数支持
        if(isset($array[1])){
            $temp = call_user_func($array[1], $temp);
        }
        $data2[$array[0]]    =   $temp;
    }
    if(!empty($grid['format'])){
        $value  =   preg_replace_callback('/\[([a-z_]+)\]/', function($match) use($data2){return $data2[$match[1]];}, $grid['format']);
    }else{
        $value  =   implode(' ',$data2);
    }

    // 链接支持
    if('title' == $grid['field'][0] && '目录' == $data['type'] ){
        // 目录类型自动设置子文档列表链接
        $grid['href']   =   '[LIST]';
    }
    if(!empty($grid['href'])){
        $links  =   explode(',',$grid['href']);
        foreach($links as $link){
            $array  =   explode('|',$link);
            $href   =   $array[0];
            if(preg_match('/^\[([a-z_]+)\]$/',$href,$matches)){
                $val[]  =   $data2[$matches[1]];
            }else{
                $show   =   isset($array[1])?$array[1]:$value;
                // 替换系统特殊字符串
                $href   =   str_replace(
                    array('[DELETE]','[EDIT]','[LIST]'),
                    array('setstatus?status=-1&ids=[id]',
                    'edit?id=[id]&model=[model_id]&cate_id=[category_id]',
                    'index?pid=[id]&model=[model_id]&cate_id=[category_id]'
                    		
                    ),
                    $href);

                // 替换数据变量
                $href   =   preg_replace_callback('/\[([a-z_]+)\]/', function($match) use($data){return $data[$match[1]];}, $href);

                $val[]  =   '<a href="'.U($href).'">'.$show.'</a>';
            }
        }
        $value  =   implode(' ',$val);
    }
    return $value;
}

/* 解析插件数据列表定义规则*/

function get_addonlist_field($data, $grid,$addon){
    // 获取当前字段数据
    foreach($grid['field'] as $field){
        $array  =   explode('|',$field);
        $temp  =    $data[$array[0]];
        // 函数支持
        if(isset($array[1])){
            $temp = call_user_func($array[1], $temp);
        }
        $data2[$array[0]]    =   $temp;
    }
    if(!empty($grid['format'])){
        $value  =   preg_replace_callback('/\[([a-z_]+)\]/', function($match) use($data2){return $data2[$match[1]];}, $grid['format']);
    }else{
        $value  =   implode(' ',$data2);
    }

    // 链接支持
    if(!empty($grid['href'])){
        $links  =   explode(',',$grid['href']);
        foreach($links as $link){
            $array  =   explode('|',$link);
            $href   =   $array[0];
            if(preg_match('/^\[([a-z_]+)\]$/',$href,$matches)){
                $val[]  =   $data2[$matches[1]];
            }else{
                $show   =   isset($array[1])?$array[1]:$value;
                // 替换系统特殊字符串
                $href   =   str_replace(
                    array('[DELETE]','[EDIT]','[ADDON]'),
                    array('del?ids=[id]&name=[ADDON]','edit?id=[id]&name=[ADDON]',$addon),
                    $href);

                // 替换数据变量
                $href   =   preg_replace_callback('/\[([a-z_]+)\]/', function($match) use($data){return $data[$match[1]];}, $href);

                $val[]  =   '<a href="'.U($href).'">'.$show.'</a>';
            }
        }
        $value  =   implode(' ',$val);
    }
    return $value;
}

// 获取模型名称
function get_model_by_id($id){
    return $model = M('Model')->getFieldById($id,'title');
}

// 获取属性类型信息
function get_attribute_type($type=''){
    // TODO 可以加入系统配置
    static $_type = array(
        'num'       =>  array('数字','int(10) UNSIGNED NOT NULL'),
        'string'    =>  array('字符串','varchar(255) NOT NULL'),
        'textarea'  =>  array('文本框','text NOT NULL'),
        'date'      =>  array('日期','int(10) NOT NULL'),
        'datetime'  =>  array('时间','int(10) NOT NULL'),
        'bool'      =>  array('布尔','tinyint(2) NOT NULL'),
        'select'    =>  array('枚举','char(50) NOT NULL'),
        'radio'     =>  array('单选','char(10) NOT NULL'),
        'checkbox'  =>  array('多选','varchar(100) NOT NULL'),
        'editor'    =>  array('编辑器','text NOT NULL'),
        'picture'   =>  array('上传图片','varchar(100) NOT NULL'),
        'file'      =>  array('上传附件','varchar(100) NOT NULL')
    );
    return $type?$_type[$type][0]:$_type;
}

/**
 * 获取对应状态的文字信息
 * @param int $status
 * @return string 状态文字 ，false 未获取到
 * @author huajie <banhuajie@163.com>
 */
function get_status_title($status = null){
    if(!isset($status)){
        return false;
    }
    switch ($status){
        case -1 : return    '已删除';   break;
        case 0  : return    '禁用';     break;
        case 1  : return    '正常';     break;
        case 2  : return    '待审核';   break;
        case 4  : return    '未通过';   break;
        default : return    false;      break;
    }
}

// 获取数据的状态操作
function show_status_op($status) {
    switch ($status){
        case 0  : return    '启用';     break;
        case 1  : return    '禁用';     break;
        case 2  : return    '审核';       break;
        default : return    false;      break;
    }
}


// 获取栏目用户信息
function get_user_lanmu($lanmu) {
	$member = D('Member');
    $data =	$member->field('uid,nickname')->where('lanmu='.$lanmu.' AND status=1')->select();
    return $data;
}

/**
 * 获取文档的类型文字
 * @param string $type
 * @return string 状态文字 ，false 未获取到
 * @author huajie <banhuajie@163.com>
 */
function get_document_type($type = null){
    if(!isset($type)){
        return false;
    }
    switch ($type){
        case 1  : return    '目录'; break;
        case 2  : return    '主题'; break;
        case 3  : return    '段落'; break;
        default : return    false;  break;
    }
}


/**
 * 获取推荐
 * @param string $type
 * @return string 状态文字 ，false 未获取到
 * @author huajie <banhuajie@163.com>
 */
function get_position_type($type = 0){
	if(!isset($type)){
		return 0;
	}
	switch ($type){
		case 1  : return    '最新推荐'; break;
		case 2  : return    '频道推荐'; break;
		case 4  : return    '首页推荐'; break;
		default : return    0;  break;
	}
}

/**
 * 获取配置的类型
 * @param string $type 配置类型
 * @return string
 */
function get_config_type($type=0){
    $list = C('CONFIG_TYPE_LIST');
    return $list[$type];
}

/**
 * 获取配置的分组
 * @param string $group 配置分组
 * @return string
 */
function get_config_group($group=0){
    $list = C('CONFIG_GROUP_LIST');
    return $group?$list[$group]:'';
}

/**
 * select返回的数组进行整数映射转换
 *
 * @param array $map  映射关系二维数组  array(
 *                                          '字段名1'=>array(映射关系数组),
 *                                          '字段名2'=>array(映射关系数组),
 *                                           ......
 *                                       )
 * @author 朱亚杰 <zhuyajie@topthink.net>
 * @return array
 *
 *  array(
 *      array('id'=>1,'title'=>'标题','status'=>'1','status_text'=>'正常')
 *      ....
 *  )
 *
 */
function int_to_string(&$data,$map=array('status'=>array(1=>'正常',-1=>'删除',0=>'禁用',2=>'未审核',3=>'草稿'))) {
    if($data === false || $data === null ){
        return $data;
    }
    $data = (array)$data;
    foreach ($data as $key => $row){
        foreach ($map as $col=>$pair){
            if(isset($row[$col]) && isset($pair[$row[$col]])){
                $data[$key][$col.'_text'] = $pair[$row[$col]];
            }
        }
    }
    return $data;
}

/**
 * 动态扩展左侧菜单,base.html里用到
 * @author 朱亚杰 <zhuyajie@topthink.net>
 */
function extra_menu($extra_menu,&$base_menu){
    foreach ($extra_menu as $key=>$group){
        if( isset($base_menu['child'][$key]) ){
            $base_menu['child'][$key] = array_merge( $base_menu['child'][$key], $group);
        }else{
            $base_menu['child'][$key] = $group;
        }
    }
}

/**
 * 获取参数的所有父级分类
 * @param int $cid 分类id
 * @return array 参数分类和父类的信息集合
 * @author huajie <banhuajie@163.com>
 */
function get_parent_category($cid){
    if(empty($cid)){
        return false;
    }
    $cates  =   M('Category')->where(array('status'=>1))->field('id,title,pid')->order('sort')->select();
    $child  =   get_category($cid); //获取参数分类的信息
    $pid    =   $child['pid'];
    $temp   =   array();
    $res[]  =   $child;
    while(true){
        foreach ($cates as $key=>$cate){
            if($cate['id'] == $pid){
                $pid = $cate['pid'];
                array_unshift($res, $cate); //将父分类插入到数组第一个元素前
            }
        }
        if($pid == 0){
            break;
        }
    }
    return $res;
}

/**
 * 检测验证码
 * @param  integer $id 验证码ID
 * @return boolean     检测结果
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function check_verify($code, $id = 1){
    $verify = new \Think\Verify();
    return $verify->check($code, $id);
}

/**
 * 获取当前分类的文档类型
 * @param int $id
 * @return array 文档类型数组
 * @author huajie <banhuajie@163.com>
 */
function get_type_bycate($id = null){
    if(empty($id)){
        return false;
    }
    $type_list  =   C('DOCUMENT_MODEL_TYPE');
    $model_type =   M('Category')->getFieldById($id, 'type');
    $model_type =   explode(',', $model_type);
    foreach ($type_list as $key=>$value){
        if(!in_array($key, $model_type)){
            unset($type_list[$key]);
        }
    }
    return $type_list;
}

/**
 * 获取当前文档的分类
 * @param int $id
 * @return array 文档类型数组
 * @author huajie <banhuajie@163.com>
 */
function get_cate($cate_id = null){
    if(empty($cate_id)){
        return false;
    }
    $cate   =   M('Category')->where('id='.$cate_id)->getField('title');
    return $cate;
}

 // 分析枚举类型配置值 格式 a:名称1,b:名称2
function parse_config_attr($string) {
    $array = preg_split('/[,;\r\n]+/', trim($string, ",;\r\n"));
    if(strpos($string,':')){
        $value  =   array();
        foreach ($array as $val) {
            list($k, $v) = explode(':', $val);
            $value[$k]   = $v;
        }
    }else{
        $value  =   $array;
    }
    return $value;
}

// 获取子文档数目
function get_subdocument_count($id=0){
    return  M('Document')->where('pid='.$id)->count();
}



 // 分析枚举类型字段值 格式 a:名称1,b:名称2
 // 暂时和 parse_config_attr功能相同
 // 但请不要互相使用，后期会调整
function parse_field_attr($string) {
    if(0 === strpos($string,':')){
        // 采用函数定义
        return   eval('return '.substr($string,1).';');
    }elseif(0 === strpos($string,'[')){
        // 支持读取配置参数（必须是数组类型）
        return C(substr($string,1,-1));
    }
    
    $array = preg_split('/[,;\r\n]+/', trim($string, ",;\r\n"));
    if(strpos($string,':')){
        $value  =   array();
        foreach ($array as $val) {
            list($k, $v) = explode(':', $val);
            $value[$k]   = $v;
        }
    }else{
        $value  =   $array;
    }
    return $value;
}

/**
 * 获取行为数据
 * @param string $id 行为id
 * @param string $field 需要获取的字段
 * @author huajie <banhuajie@163.com>
 */
function get_action($id = null, $field = null){
    if(empty($id) && !is_numeric($id)){
        return false;
    }
    $list = S('action_list');
    if(empty($list[$id])){
        $map = array('status'=>array('gt', -1), 'id'=>$id);
        $list[$id] = M('Action')->where($map)->field(true)->find();
    }
    return empty($field) ? $list[$id] : $list[$id][$field];
}

/**
 * 根据条件字段获取数据
 * @param mixed $value 条件，可用常量或者数组
 * @param string $condition 条件字段
 * @param string $field 需要返回的字段，不传则返回整个数据
 * @author huajie <banhuajie@163.com>
 */
function get_document_field($value = null, $condition = 'id', $field = null){
    if(empty($value)){
        return false;
    }

    //拼接参数
    $map[$condition] = $value;
    $info = M('Model')->where($map);
    if(empty($field)){
        $info = $info->field(true)->find();
    }else{
        $info = $info->getField($field);
    }
    return $info;
}

/**
 * 获取行为类型
 * @param intger $type 类型
 * @param bool $all 是否返回全部类型
 * @author huajie <banhuajie@163.com>
 */
function get_action_type($type, $all = false){
    $list = array(
        1=>'系统',
        2=>'用户',
    );
    if($all){
        return $list;
    }
    return $list[$type];
}


function sendmail($tomail,$title,$content)
{
	/*邮件设置信息*/
	$email_set = C('EMAIL_SET');
	require_once('./ThinkPHP/Library/Vendor/PHPMailer/phpmailer.class.php');
	$mail = new PHPMailer(true); //实例化PHPMailer类,true表示出现错误时抛出异常

	$mail->IsSMTP(); // 使用SMTP
	$mail->SMTPDebug = 0;
	$mail->CharSet ="UTF-8";//设定邮件编码
	$mail->Host       = $email_set['Host']; // SMTP server
	$mail->SMTPAuth   = true;                  // 服务器需要验证
	$mail->Port       = $email_set['port'];                    // 设置端口
	// $mail->SMTPSecure = "ssl";
	/*
	 $mail->SMTPSecure = "ssl";
	 $mail->Host       = "smtp.gmail.com";
	 $mail->Port       = 465;
	*/

	$mail->Username   = $email_set['email_user']; //SMTP服务器的用户帐号
	$mail->Password   = $email_set['email_pwd'];       //SMTP服务器的用户密码
	$mail->AddReplyTo($email_set['email'],$email_set['email_name']); //收件人回复时回复到此邮箱,可以多次执行该方法
	if (is_array($tomail)){
		foreach ($tomail as $m){
			$mail->AddAddress($m, 'user');
		}
	}else{
		$mail->AddAddress($tomail, 'user');
	}
	 
	$mail->SetFrom($email_set['email'],$email_set['email_name']);
	// $mail->AddAttachment('./img/phpmailer.gif');      // 添加附件,如果有多个附件则重复执行该方法
	$mail->Subject = $title;

	//以下是邮件内容相关
	$mail->Body = $content;
	$mail->IsHTML(true);

	//$body = file_get_contents('tpl.html'); //获取html网页内容
	// $mail->MsgHTML(eregi_replace("[]",'',$body));
	return $mail->Send()? true: $mail->ErrorInfo;
}
