<?php
/**
 * Created by: Jiar
 * Github: https://www.github.com/Jiar/
 */

namespace Qwechat\Model;

use Think\Model;
use Qwechat\Sdk\TPWechat;
use Qwechat\Sdk\errCode;

class QwechatMemberModel extends Model {
    
    protected $_validate = array(
        array('userid','require','成员userId不能为空', self::EXISTS_VALIDATE),
        array('name','require','成员名称不能为空', self::EXISTS_VALIDATE),
    );

    /********************** Controller's Function 对应 Model 操作 -start **********************/

    /**
     * @param  $department_id 部门id
     * @param  $fetch_child   1/0：是否递归获取子部门下面的成员
     * @param  $status        0获取全部员工，1获取已关注成员列表，2获取禁用成员列表，4获取未关注成员列表。status可叠加
     * @param  $reFetch       true:从微信企业号后台获取(同时覆盖本地数据) false:从本地数据库获取
     * @return 成员集合
     */
    public function getUserListInfo($department_id=1,$fetch_child=1,$status=0,$reFetch=false) {
        if($reFetch || D('QwechatMember')->Count() == 0) {
            $this->getUserListInfoFromQwechatToSave($department_id,$fetch_child,$status);
        }
        return $this->getUserListInfoFromLocal($department_id,$fetch_child,$status);
    }

    /**
     * 员工详情
     * @param  $userid 员工账号
     * @return 员工详情
     */
    public function getEmployeeDetail($userid) {
        $member = D('QwechatMember')->find($userid);
        $departmentIds = explode(",", $member['department']);
        $departments = array();
        foreach ($departmentIds as  $departmentId) {
            if(!empty($departmentId)) {
                $department = D('QwechatDepartment')->find($departmentId);
                array_push($departments, $department);
            }
        }
        $result['member'] = $member;
        $result['departments'] = $departments;
        return $result;
    }

    /********************** Controller's Function 对应 Model 操作 -end **********************/


    /********************** private -start **********************/

    /**
    * 从微信企业号后台请求所有成员覆盖本地数据库
    */
    private function getUserListInfoFromQwechatToSave($department_id=1,$fetch_child=1,$status=0) {
        //从微信企业号后台请求所有成员覆盖本地数据库的同时也需要从微信企业号后台请求所有部门覆盖本地数据库
        $membersBf = $this->getUserListInfoFromQwechat($department_id,$fetch_child,$status);
        if($membersBf['errcode'] == 0) {
            $membersBf = $membersBf['userlist'];
            $members = array();
            $membersBfCount = count($membersBf);
            for($i=0;$i<$membersBfCount;$i++) {
                $member = $membersBf[$i];
                $departmentArr = $member['department'];
                $departmentArrCount = count($departmentArr);
                $departmentStr = '';
                for($j=0;$j<$departmentArrCount;$j++) {
                    $departmentStr .= ',' .$departmentArr[$j];
                }
                if(count($departmentStr) != 0) {
                    $departmentStr .= ',';
                }
                $member['department'] = $departmentStr;
                array_push($members, $member);
            }
            M("QwechatMember")->where('1')->delete();
            // 如果使用addAll，会出现如果某个字段没有值，则报错的现象（听说这是个Bug。3.2.3有这个问题，3.2.2没有这个问题）
            // M("QwechatMember")->addAll($members);
            foreach ($members as $member) {
                M("QwechatMember")->add($member);
            }
        }
    }

    /**
     * 从微信企业号后台获取部门成员详情列表
     * 
     * @param $department_id   部门id
     * @param $fetch_child     1/0：是否递归获取子部门下面的成员
     * @param $status          0获取全部员工，1获取已关注成员列表，2获取禁用成员列表，4获取未关注成员列表。status可叠加
     * @return boolean|array     成功返回结果
     * {
     *    "errcode": 0,
     *    "errmsg": "ok",
     *    "userlist": [
     *            {
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
     *      ]
     * }
     */
    private function getUserListInfoFromQwechat($department_id=1,$fetch_child=1,$status=0) {
        $weObj = TPWechat::getInstance();
        return $weObj->getUserListInfo($department_id, $fetch_child, $status);
    }

    /**
     * 从微信企业号后台获取部门成员详情列表
     * 
     * @param $department_id   部门id
     * @param $fetch_child     1/0：是否递归获取子部门下面的成员
     * @param $status          0获取全部员工，1获取已关注成员列表，2获取禁用成员列表，4获取未关注成员列表。status可叠加
     * @return 成员集合
     */
    private function getUserListInfoFromLocal($department_id=1,$fetch_child=1,$status=0) {
        $where = array();
        if(status == 1) {
            $where['status'] = 1;
        } else if(status == 2) {
            $where['status'] = 2;
        } else if(status == 4) {
            $where['status'] = 4;
        } else if(status == 3) {
            // $where['status'] = array('in','1,2');
            $where['status'] = array('in',array(1, 2));
        } else if(status == 5) {
            // $where['status'] = array('in','1,4');
            $where['status'] = array('in',array(1, 4));
        } else if(status == 6) {
            // $where['status'] = array('in','2,4');
            $where['status'] = array('in',array(2, 4));
        } else if(status == 0 || status == 7) {
            // $where['status'] = array('in','1,2,4');
            $where['status'] = array('in',array(1, 2, 4));
        }
        if($fetch_child == 0) {
            $where['department']=array('like',','.$department_id.',');
        } else if($fetch_child == 1) {
            $departmentIds = $this->getSubDepartmentIds($department_id);
            $result = array();
            foreach($departmentIds as $departmentId) {
                array_push($result, '%,'.$departmentId.',%');
            }
            $where['department'] = array('like',$result,'OR');
        }
        return M('QwechatMember')->distinct(true)->where($where)->select(); 
    }

    /**
     * 获取当前部门下的所有子部门的Id集合(包括当前部门本身)
     * 
     * @param  $department_id 当前部门Id
     * @return 部门Id集合
     */
    private function getSubDepartmentIds($department_id) {
        $list = M("QwechatDepartment")->getField('id, parentid');
        $result = array();
        array_push($result, $department_id);
        $this->recursionSubDepartmentIds($list, $result, $department_id);
        return $result;
    }

    /**
     * 获取当前部门下的所有子部门的Id集合(递归过程)
     *
     * @param  $list          部门Id对应父部门Id关联数组
     * @param  &$result       返回结果数组指针
     * @param  $department_id 当前部门Id
     */
    private function recursionSubDepartmentIds($list, &$result, $department_id) {
        reset($list);
        while (key($list) !== null) {
            if($department_id == current($list)) {
                array_push($result, key($list));
                $this->recursionSubDepartmentIds($list, $result, key($list));
            }
            next($list);
        }
    }

    /********************** private -end **********************/


}
