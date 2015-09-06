<?php

/**
 * @description 字典
 * @Author: lipeng
 * @CreateTime: 2015-08-04 10:41:09
 */

namespace Common\Model;
use Think\Model;

/**
* 字典模型
* @author lipeng
*/

class OcuserdetailModel extends Model {
	
	protected $connection = 'DB_CONFIG2';

    protected $trueTableName = 'oc_users_detail';

    /* 自动验证规则 */
    protected $_validate = array(

    );
    /* 自动完成规则 */
    protected $_auto = array(

    );
}