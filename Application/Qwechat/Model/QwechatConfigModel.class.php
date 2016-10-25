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
        array('corpid','require','请输入CorpID', self::EXISTS_VALIDATE),
        array('corpsecret','require','请输入Secret', self::EXISTS_VALIDATE),
    );
	protected $autoCheckFields = true;
    protected $_auto = array(
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
    );


    /********************** Controller's Function 对应 Model 操作 -start **********************/

    /**
     * 保存基础配置（corpid、corpsecret）
     * 
     * @param  corpid
     * @param  corpsecret
     * @return bool
     */
    public function saveConfig($corpid, $corpsecret) {
    	$options = array(
	   		'appid'=>$corpid,
	   		'appsecret'=>$corpsecret,
	   	);
        $weObj = TPWechat::getInstance($options);
        $access_token = $weObj->checkAuth();
        trace('access_token:' .$access_token);
        if($access_token) {
            // 清空数据
            M("QwechatConfig")->where('1')->delete();
        	$where['corpid'] = $corpid;
        	$where['corpsecret'] = $corpsecret;
        	if(count(D('QwechatConfig')->where($where)->select()) == 0) {
        		$data = $where;
        		D('QwechatConfig')->add($data);
        	}
        	return true;
        }
        return false;
    }

    /**
     *获取基础配置（corpid、corpsecret）
     * 
     * @return array('corpid'=>'value', 'corpsecret'=>'value');
     */
    public function getConfig() {
        return D('QwechatConfig')->find();
    }

    /********************** Controller's Function 对应 Model 操作 -end **********************/


}