<?php
/**
 * Created by: Jiar
 */

namespace Qwechat\Controller;

/**
* 员工管理分栏控制器
*/
class EmployeeController extends BaseController {
	
	/**
	* 员工管理
	*/
	public function employeeManage_action() {
		$this->display('employeeManage');
	}

	/**
	* 离职员工
	*/
	public function leaveEmployee_action() {
		$this->display('leaveEmployee');
	}

}