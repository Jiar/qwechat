<?php
/**
 * Created by: Jiar
 */

namespace Qwechat\Controller;

/**
* 消息管理分栏控制器
*/
class MessageController extends BaseController {
	
	/**
	* 主动消息
	*/
	public function activeMessage_action() {
		$this->display('activeMessage');
	}

	/**
	* 消息列表
	*/
	public function messageList_action() {
		$this->display('messageList');
	}
	
}