<?php

/**
 * @description 公告
 * @Author: lipeng
 * @CreateTime: 2015-08-11 16:02:05
 */

namespace Common\Model;
use Think\Model;

/**
* 公告模型
* @author lipeng
*/

class NoticeModel extends Model{
	
	protected $connection = 'DB_CONFIG2';

    protected $trueTableName = 'oc_notice';

    /* 自动验证规则 */
    protected $_validate = array(
    		array('title', 'require', '标题不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    		array('cover_url', 'require', '配图不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    	
    );
    /* 自动完成规则 */
    protected $_auto = array(

    );
}