<?php
/**
 * Created by: Jiar
 */

namespace Qwechat\Controller;

/**
* 应用管理分栏控制器
*/
class ApplicationController extends BaseController {
	
	/**
	* 应用管理
	*/
	public function applicationManage_action() {
		$this->display('applicationManage');
	}

	/**
	* 基础配置
	*/
	public function basicConfig_action() {
		$this->display('basicConfig');
	}

}