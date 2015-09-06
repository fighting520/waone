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

class MusicDetailModel extends Model {
	
	protected $connection = 'DB_CONFIG2';

    protected $trueTableName = 'oc_music_detail';

    /* 自动验证规则 */
    protected $_validate = array(

    );
    /* 自动完成规则 */
    protected $_auto = array(

    );
}