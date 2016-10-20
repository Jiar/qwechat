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
	public function activeMessage_action {
		echo '主动消息';
	}

	/**
	* 消息列表
	*/
	public function messageList_action {
		echo '消息列表';
	}
	
}