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
     * @param  $reFetch       true:从微信企业号后台获取(同时覆盖本地数据，此时从后台获取所有数据，无分页) false:从本地数据库获取
     * @param  $pageIndex     分页查询：第几页
     * @param  $pageSize      分页查询：每页数量
     * @return 成员集合信息     array('pageIndex'=>?,'pageSize'=>'?,count'=>?,'members'=>?)
     */
    public function employeeManage_action($department_id=1,$fetch_child=1,$status=0,$reFetch=false,$pageIndex=1,$pageSize=10) {
    	$memberInfos = D('QwechatMember')->getUserListInfo($department_id,$fetch_child,$status,$reFetch,$pageIndex,$pageSize);
        $members = $memberInfos['members'];
        $pageIndex = $memberInfos['pageIndex'];
        $pageNumbers = ($memberInfos['count']+$memberInfos['pageSize'])/$memberInfos['pageSize'];
    	$this->assign('members', $members);
        $this->assign('pageIndex', $pageIndex);
        $this->assign('pageNumbers', $pageNumbers);
    	$this->display('Employee/employeeManage');
    }

	/**
	 * 离职员工
	 */
	public function leaveEmployee_action() {
		$this->display('Employee/leaveEmployee');
	}

    /**
     * 员工详情
     * @param  $userid 员工账号
     * @return 员工详情
     */
    public function employeeDetail_action($userid) {
        $result = D('QwechatMember')->getEmployeeDetail($userid);
        $this->assign('member', $result['member']);
        $this->assign('departments', $result['departments']);
        $this->display('Employee/employeeDetail');
    }

    /**
     * 批量删除员工
     */
    public function deleteEmployees_action(){
        $memberIds = I('post.memberIds');
        $result = D('QwechatMember')->deleteEmployees($memberIds);

        if($result) {
            $backEntity['success'] = 1;
            $backEntity['info'] = L('_DELETE_SUCCESS_');
        } else {
            $backEntity['success'] = 0;
            $backEntity['info'] = L('_DELETE_FAIL_');
        }
        $backEntity['info'] = $result;
        $this->ajaxReturn(json_encode($backEntity), 'JSON');
    }

}

