<?php

/**
 * @description 音乐人音乐
 * @Author: lipeng
 * @CreateTime: 2015-07-28 09:51:06
 */

namespace Common\Model;
use Think\Model;

/**
* 音乐人音乐模型
* @author lipeng
*/

class MusicModel extends Model {

	
	
    protected $trueTableName = 'cms_resource';

    
    /* 自动验证规则 */
    protected $_validate = array(	
    	//	array('filename', 'require', '128音档不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    	//	array('filename320', 'require', '320音档不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
  
    		array('songer', 'require', '歌手不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    		array('songphoto', 'require', '配图不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    		array('songname', 'require', '歌名不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    );
    
    /* 自动完成规则 */
    protected $_auto = array(
    		array('resourcecode', 'getCode', self::MODEL_INSERT, 'function', 1),
    );
    
    function getCode(){
    	return date('YmdHis');;
    }
}