																																			<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

/**
 * 系统配文件
 * 所有系统级别的配置
 */
return array(

     'WEB_URL'=>'http://wawafm.jios.org:8890/',
    /* 模块相关配置 */
    'AUTOLOAD_NAMESPACE' => array('Addons' => ONETHINK_ADDON_PATH), //扩展模块列表
    'DEFAULT_MODULE'     => 'Home',
    //'MODULE_DENY_LIST'   => array('Common','User','Admin','Install'),
    'MODULE_ALLOW_LIST'  => array('Home','Admin'),

    /* 系统数据加密设置 */
    'DATA_AUTH_KEY' => '-r?fE@21|9:ku>Ys$Jy5aG;6lBR`}8M#=[pc)gvW', //默认数据加密KEY

    /* 用户相关设置 */
    'USER_MAX_CACHE'     => 1000, //最大缓存用户数
    'USER_ADMINISTRATOR' => 1, //管理员用户ID

    /* URL配置 */
    'URL_CASE_INSENSITIVE' => true, //默认false 表示URL区分大小写 true则表示不区分大小写
    'URL_MODEL'            => 3, //URL模式
    'VAR_URL_PARAMS'       => '', // PATHINFO URL参数变量
    'URL_PATHINFO_DEPR'    => '/', //PATHINFO URL分割符

    /* 全局过滤配置 */
    'DEFAULT_FILTER' => '', //全局过滤函数

     /* 数据库配置 */
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => '55b97f15234e9.gz.cdb.myqcloud.com', // 服务器地址
    'DB_NAME'   => 'rptuser', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => 'qazxswedcvfr520',  // 密码
    'DB_PORT'   => '13120', // 端口
    'DB_PREFIX' => 'wa_', // 数据库表前缀
    
    
    /* 数据缓存设置 */
    'DATA_CACHE_TIME'       =>  600,      // 数据缓存有效期 0表示永久缓存   10分钟
    'DB_SQL_BUILD_CACHE' => true,
    'DB_SQL_BUILD_QUEUE' => 'xcache',
    'DB_SQL_BUILD_LENGTH' => 100, // SQL缓存的队列长度
    
    'DB_CONFIG2' => 'mysql://root:qazxswedcvfr520@55b97f15234e9.gz.cdb.myqcloud.com:13120/oxwawa#utf8',
    

    /* 文档模型配置 (文档模型核心配置，请勿更改) */
    'DOCUMENT_MODEL_TYPE' => array(2 => '主题', 1 => '目录', 3 => '段落'),
    
    /**
     * fastdfs文件上传配置
     */
    'PFASTDFS_UPLOAD' => array(
    		'maxSize'       =>  200*1024*1024, //上传的文件大小限制 (0-不做限制)
    		'exts'          =>  'jpg,gif,png,jpeg,zip,rar,tar,gz,7z,doc,docx,txt,xml,mp3,wma,apk,app', //允许上传的文件后缀
    		'tracker_addr' => 'wawafm.jios.org',//上传的ip；
    		'tracker_port' => 22122,//上传的端口
    		'group_name' =>'group1',//上传群组
    		'server_name'=>'http://wawafm.jios.org:8888/'
    
    ),
);
