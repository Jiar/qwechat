<?php
/**
 * Created by: Jiar
 */

namespace Qwechat\Controller;

/**
 * 企业微信入口
 */
class QwechatController extends BaseController {
	
	/**
	 * 企业微信入口
	 */
	public function qwechat_action() {
		$this->display('Qwechat/qwechat');
	}

}