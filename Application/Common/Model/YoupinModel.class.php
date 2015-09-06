<?php

/**
 * @description 有品
 * @Author: lipeng
 * @CreateTime: 2015-08-11 16:01:28
 */

namespace Common\Model;
use Think\Model;

/**
* 有品模型
* @author lipeng
*/

class YoupinModel extends Model {
	
	protected $connection = 'DB_CONFIG2';

    protected $trueTableName = 'oc_youpin';

    /* 自动验证规则 */
    protected $_validate = array(

    );
    /* 自动完成规则 */
    protected $_auto = array(

    );
}