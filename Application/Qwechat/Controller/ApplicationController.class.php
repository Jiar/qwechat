<?php
/**
 * Created by: Jiar
 */

namespace Qwechat\Controller;

use Qwechat\Model\QwechatModel;
use Qwechat\Model\QwechatConfigModel;

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
		$this->display('Application/applicationManage');
	}

	/**
	* 基础配置
	*/
	public function basicConfig_action($corpid = '', $corpsecret = '') {
		if(IS_POST) {
			$corpid = I('post.corpid');
			$corpsecret = I('post.corpsecret');
	   		if(D('QwechatConfig')->saveConfig($corpid, $corpsecret)) {
				$this->redirect('basicConfig', array('corpid'=>$corpid, 'corpsecret'=>$corpsecret));
	   		} else {
	   			$this->error('CorpID或Secret有误');
	   		}
		} 
		if(IS_GET) {
			if($corpid == '' || $corpsecret == '') {
				$data = D('QwechatConfig')->getConfig();
				$corpid = $data['corpid'];
				$corpsecret = $data['corpsecret'];
			}
			$this->assign('corpid', $corpid);
			$this->assign('corpsecret', $corpsecret);
			$this->display('Application/basicConfig');
		}
	}

}