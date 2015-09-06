<?php

/**
 * @description 有品
 * @Author: lipeng
 * @CreateTime: 2015-08-11 16:01:28
 */

namespace Common\Model;
use Think\Model;

/**
* 有品详情模型
* @author lipeng
*/

class YoupinDetailModel extends Model {
	
	protected $connection = 'DB_CONFIG2';

    protected $trueTableName = 'oc_youpin_detail';

    /* 自动验证规则 */
    protected $_validate = array(
    		array('title', 'require', '标题不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    		array('cover_url', 'require', '配图不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    		array('adtype', 'require', '广告类型不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    		array('link', 'require', '链接不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    );
    /* 自动完成规则 */
    protected $_auto = array(

    );
}