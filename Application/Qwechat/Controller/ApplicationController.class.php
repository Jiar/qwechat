<?php
/**
 * Created by: Jiar
 */

namespace Qwechat\Controller;

use Qwechat\Model\QwechatModel;

/**
* 应用管理分栏控制器
*/
class ApplicationController extends BaseController {
	
	/**
	* 应用管理
	*
	* 分页获取企业应用列表
	*/
	public function applicationManage_action($page = 1, $row = 20) {
		// $mode = new QwechatModel();
		// $result = $mode -> applicationManage($page, $row);
		// $this->assign('list', $result['list']);
		// $this->assign('totalCount', $result['totalCount']);
		$this->display('applicationManage');
	}

	/**
	* 基础配置
	*/
	public function basicConfig_action($appid = '', $appsecret = '') {
		if(IS_POST) {
			$appid = I('post.APPID');
			$appsecret = I('post.APPSECRET');
	   		$config = M('QwechatConfig');
	   		$config->saveConfig($appid, $appsecret);
	   		$this->redirect('basicConfig', array('appid'=>$appid, 'appsecret'=>$appsecret));
		} 
		if(IS_GET) {
			$this->assign('appid', $appid);
			$this->assign('appsecret', $appsecret);
			$this->display('basicConfig');
		}
	}

}