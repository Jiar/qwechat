<?php
/**
 * Created by: Jiar
 * Github: https://www.github.com/Jiar/
 */

namespace Qwechat\Model;

use Think\Model;
use Qwechat\Sdk\TPWechat;
use Qwechat\Sdk\errCode;

class QwechatConfigModel extends Model {

	protected $patchValidate = ture;
	protected $_validate = array(
        array('corpid','require','请输入CorpID'),
        array('corpsecret','require','请输入Secret'),
        array('access_token','require','未获取到access_token'),
    );
	protected $autoCheckFields = true;
    protected $_auto = array(
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
    );

    /**
     * 保存基础配置
     * 
     * @param  appid
     * @param  appsecret
     * @return bool
     */
    public function saveConfig($appid, $appsecret) {
    	$option = array(
	   		'appid'=>$appid,
	   		'appsecret'=>$appsecret,
	   	);
	   	$weObj = new TPWechat($option);
	   	
        $weObj = $weObj->checkAuth();
        trace($weObj);

        if($weObj) {
        	$config = D('QwechatConfig');
        	$where['corpid'] = $appid;
        	$where['corpsecret'] = $appsecret;
        	if(count($config->where($where)->select()) == 0) {
        		$data = $where;
                trace('$data1:' .$data);
                $data['corpid'] = $appid;
                $data['corpsecret'] = $appsecret;
                trace('$data2:' .$data);
        		D('QwechatConfig')->data($data)->save();
        	}
        	return true;
        }
        return false;
    }

}