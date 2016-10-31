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
		$this->display('Organize/groupSettings');
	}

	/**
	* 分店管理
	*/
	public function branchManage_action() {
		$this->display('Organize/branchManage');
	}

	/**
	* 部门管理
	*/
	public function departmentManage_action($reFetch=false) {
		$departments = D('QwechatDepartment')->departmentManage($reFetch);
		$this->assign('departments', $departments);
		$this->display('Organize/departmentManage');
	}

	/**
	 * 添加子部门
	 */
	public function createSubDepartment_action() {
		$sup_department_id = I('post.sup_department_id');
		$sub_department_name = I('post.sub_department_name');
		$backEntity = array();
		if(D('QwechatDepartment')->createSubDepartment($sup_department_id, $sub_department_name)) {
			// $this->redirect('Organize/departmentManage' ,array($reFetch=>true));
			$backEntity['success'] = 1;
            $backEntity['info'] = L('_ADD_SUCCESS_');
		} else {
			$backEntity['success'] = 0;
            $backEntity['info'] = L('_ADD_FAIL_');
		}
		$this->ajaxReturn(json_encode($backEntity), 'JSON');
	}

	/**
	 * 更新部门信息
	 */
	public function updateDepartment_action() {
		$department_id = I('post.department_id');
		$department_name = I('post.department_name');
		$backEntity = array();
		if(D('QwechatDepartment')->updateDepartment($department_id, $department_name)) {
			// $this->redirect('Organize/departmentManage' ,array($reFetch=>true));
			$backEntity['success'] = 1;
            $backEntity['info'] = L('_UPDATE_SUCCESS_');
		} else {
			$backEntity['success'] = 0;
            $backEntity['info'] = L('_UPDATE_FAIL_');
		}
		$this->ajaxReturn(json_encode($backEntity), 'JSON');
	}

	/**
	 * 删除部门
	 */
	public function deleteDepartment_action() {
		$department_id = I('post.department_id');
		$backEntity = array();
		if(D('QwechatDepartment')->deleteDepartment($department_id)) {
			// $this->redirect('Organize/departmentManage' ,array($reFetch=>true));
			$backEntity['success'] = 1;
            $backEntity['info'] = L('_DELETE_SUCCESS_');
		} else {
			$backEntity['success'] = 0;
            $backEntity['info'] = L('_DELETE_FAIL_');
		}
		$this->ajaxReturn(json_encode($backEntity), 'JSON');
	}

}