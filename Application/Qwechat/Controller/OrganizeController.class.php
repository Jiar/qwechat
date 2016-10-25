<?php
/**
 * Created by: Jiar
 */

namespace Qwechat\Controller;

/**
* 组织设置分栏控制器
*/
class OrganizeController extends BaseController {

	/**
	* 集团设置
	*/
	public function groupSettings_action() {
		$this->display('groupSettings');
	}

	/**
	* 分店管理
	*/
	public function branchManage_action() {
		$this->display('branchManage');
	}

	/**
	* 部门管理
	*/
	public function departmentManage_action() {
		$departments = D('QwechatDepartment')->departmentManage();
		trace($departments);
		$this->assign('departments', $departments);
		$this->display('departmentManage');
	}

}