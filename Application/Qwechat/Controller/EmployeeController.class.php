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
	 * 
     * @param  $department_id 部门id
     * @param  $fetch_child   1/0：是否递归获取子部门下面的成员
     * @param  $status        0获取全部员工，1获取已关注成员列表，2获取禁用成员列表，4获取未关注成员列表。status可叠加
     * @param  $reFetch       true:从微信企业号后台获取(同时覆盖本地数据) false:从本地数据库获取
     * @return 成员集合
     */
    public function employeeManage_action($department_id=1,$fetch_child=1,$status=0,$reFetch=false) {
    	$members = D('QwechatMember')->getUserListInfo($department_id,$fetch_child,$status,$reFetch);
        echo '$members:';
        var_dump($members);
        echo '</br></br>';
    	$this->assign('members', $members);
    	$this->display('Employee/employeeManage');
    }

	/**
	 * 离职员工
	 */
	public function leaveEmployee_action() {
		$this->display('Employee/leaveEmployee');
	}

}