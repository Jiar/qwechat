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
     */
    public function employeeManage_action($department_id=1,$fetch_child=1,$status=0,$reFetch=false,$pageIndex=1,$pageSize=10) {
    	$memberInfos = D('QwechatMember')->getUserListInfo($department_id,$fetch_child,$status,$reFetch,$pageIndex,$pageSize);
        $members = $memberInfos['members'];
        $pageIndex = $memberInfos['pageIndex'];
        $pageNumbers = floor(($memberInfos['count']+$memberInfos['pageSize'])/$memberInfos['pageSize']);
    	$this->assign('members', $members);
        $this->assign('pageIndex', $pageIndex);
        $this->assign('pageNumbers', $pageNumbers);
    	$this->display('Employee/employeeManage');
    }

    /**
     * 批量获取员工信息
     * 
     * @param  $department_id 部门id
     * @param  $fetch_child   1/0：是否递归获取子部门下面的成员
     * @param  $status        0获取全部员工，1获取已关注成员列表，2获取禁用成员列表，4获取未关注成员列表。status可叠加
     * @param  $reFetch       true:从微信企业号后台获取(同时覆盖本地数据，此时从后台获取所有数据，无分页) false:从本地数据库获取
     * @param  $pageIndex     分页查询：第几页
     * @param  $pageSize      分页查询：每页数量
     * @return {"success":0, "info":"info"}
     *
     * {
     *                   "userid": "zhangsan",
     *                   "name": "李四",
     *                   "department": [1, 2],
     *                   "position": "后台工程师",
     *                   "mobile": "15913215421",
     *                   "gender": 1,     //性别。gender=0表示男，=1表示女
     *                   "tel": "62394",
     *                   "email": "zhangsan@gzdev.com",
     *                   "weixinid": "lisifordev",        //微信号
     *                   "avatar": "http://wx.qlogo.cn/mmopen/ajNVdqHZLLA3W..../0",   //头像url。注：如果要获取小图将url最后的"/0"改成"/64"即可
     *                   "status": 1      //关注状态: 1=已关注，2=已冻结，4=未关注
     *                   "extattr": {"attrs":[{"name":"爱好","value":"旅游"},{"name":"卡号","value":"1234567234"}]}
     *            }
     *            
     */
    public function employee_action($department_id=1,$fetch_child=1,$status=0,$reFetch=false,$pageIndex=1,$pageSize=10) {
        header("Access-Control-Allow-Origin: *");
        $memberInfos = D('QwechatMember')->getUserListInfo($department_id,$fetch_child,$status,$reFetch,$pageIndex,$pageSize);
        $members = $memberInfos['members'];
        $backEntity['success'] = 1;
        $backEntity['info'] = $members;
        $this->ajaxReturn(json_encode($backEntity), 'JSON');
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
     * 新增员工
     */
    public function createEmployee_action() {
        $this->display('Employee/createEmployee');
    }

    /**
     * 批量删除员工
     */
    public function deleteEmployees_action(){
        $memberIds = I('post.memberIds');
        $memberIds = explode(',', $memberIds); 
        if(D('QwechatMember')->deleteEmployees($memberIds)) {
            $backEntity['success'] = 1;
            $backEntity['info'] = L('_DELETE_SUCCESS_');
        } else {
            $backEntity['success'] = 0;
            $backEntity['info'] = L('_DELETE_FAIL_');
        }
        $this->ajaxReturn(json_encode($backEntity), 'JSON');
    }

}

