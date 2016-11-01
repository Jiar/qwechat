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
        array('id','number','id必须为数字', self::EXISTS_VALIDATE),
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
    public function getUserListInfo($department_id=0,$fetch_child=1,$status=0,$reFetch=false) {
        if($reFetch || D('QwechatMember')->Count() == 0) {
            $this->getUserListInfoFromQwechatToSave($department_id,$fetch_child,$status);
        }
        return $this->getUserListInfoFromLocal($department_id,$fetch_child,$status);
    }

    /********************** Controller's Function 对应 Model 操作 -end **********************/


    /********************** private -start **********************/

    /**
    * 从微信企业号后台请求所有成员覆盖本地数据库
    */
    private function getUserListInfoFromQwechatToSave($department_id=0,$fetch_child=1,$status=0) {
        //从微信企业号后台请求所有成员覆盖本地数据库的同时也需要从微信企业号后台请求所有部门覆盖本地数据库
        $members = $this->getUserListInfoFromQwechat($department_id,$fetch_child,$status);
        if($members['errcode'] == 0) {
            $members = $members['userlist'];
            M("QwechatMember")->where('1')->delete();
            M("QwechatMember")->addAll($members);
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
    private function getUserListInfoFromQwechat($department_id=0,$fetch_child=1,$status=0) {
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
    private function getUserListInfoFromLocal($department_id=0,$fetch_child=1,$status=0) {
        $where = array();
        if($status == 0) {
            $where['status'] = 0;
        } else if(status == 1) {
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
        } else if(status == 7) {
            // $where['status'] = array('in','1,2,4');
            $where['status'] = array('in',array(1, 2, 4));
        }
        if($fetch_child == 0) {
            $where['department']=array('like',','.$department_id.',');
        } else if($fetch_child == 1) {
            $departmentIds = $this->getSubDepartmentIds($department_id);
            $result = array();
            foreach($departmentIds as $departmentId) {
                array_push($result, ','.$departmentId.',');
            }
            var_dump($result);
            $where['department'] = array('like',$result,'OR');
        }
        var_dump($where);
        // return M('QwechatMember')->distinct(true)->where($where)->select(); 
    }

    /**
     * 获取当前部门下的所有子部门的Id集合(包括当前部门本身)
     * 
     * @param  $department_id 当前部门Id
     * @return 部门Id集合
     */
    private function getSubDepartmentIds($department_id) {
        $list = M("QwechatDepartment")->getField('id,parentid');
        $result = array();
        array_push($result, $department_id);
        return $this->recursionSubDepartmentIds($list, $result, $department_id);
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



    /********************** old -start **********************/

   public function updateMember($member=array())
    {
        $map['userid']=$member['userid'];
        $map['aid']=session('user_auth.aid');
        $member['aid']=session('user_auth.aid');

        //数据处理
        $member['department']=implode(',',$member['department']);
        $member['extattr']=serialize($member['extattr']);

        $have = M("QwechatMember")->where($map)->find();

        if ($have){
            M("QwechatMember")->where($map)->save($member);
            return "update";
        }else{
            M("QwechatMember")->add($member);
            return "add";
        }
    }

     /**
     * 获取分类详细信息
     * @param $id
     * @param bool $field
     * @return mixed
     * @author 郑钟良<zzl@ourstu.com>
     */
    public function info($id, $field = true){
        /* 获取分类信息 */
        $map = array();
        if(is_numeric($id)){ //通过ID查询
            $map['id|mobile'] = $id;
        } else { //通过标识查询
            $map['name'] = $id;
        }
        $wechatMember=$this->field($field)->where($map)->find();
       
        $notice.="/:sun粉丝号：".$wechatMember['id']." \n";
        $notice.="/:sun手机号：". ($wechatMember['mobile']?$wechatMember['mobile']:'未完善信息')." \n";
        $notice.="/:sun持卡人：". ($wechatMember['remark']?$wechatMember['remark']:$wechatMember['name'])." \n";
        $notice.="/:sun账户余额：".($wechatMember['amount']?$wechatMember['amount']:0)."元 \n";
       
       

        $wechatMember['notice']=$notice;
        return $wechatMember;
    }

      /**
     * 获取分类详细信息
     * @param $id
     * @param bool $field
     * @return mixed
     * @author 郑钟良<zzl@ourstu.com>
     */
    public function infoByUserid($userid, $field = true){
        /* 获取分类信息 */
        $map['userid'] = $userid;

        $wechatMember=$this->field($field)->where($map)->find();
        $shop=M('QwechatShop')->where(array('id'=>$wechatMember['shopid']))->getfield('name');
        $notice.="/:sun姓名：". ($wechatMember['remark']?$wechatMember['remark']:$wechatMember['name'])." \n";
        $notice.="/:sun所在分店：".$shop." \n";
        $notice.="/:sun员工编号：".$wechatMember['id']." \n";
        $notice.="/:sun微信编号：".$wechatMember['userid']." \n";
        $notice.="/:sun手机号：". ($wechatMember['mobile']?$wechatMember['mobile']:'未完善信息')." \n";
        $notice.="/:sun账户余额：".($wechatMember['amount']?$wechatMember['amount']:0)."元 \n";
        // $notice.="/:sun ".'<a href="http://'.$_SERVER[HTTP_HOST].U('Qwechat/index/editMy',array('userid'=>$wechatMember['userid'])).'">更改我的资料</a>';
       
      

        $wechatMember['notice']=$notice;
       
        return $wechatMember;
    }


     public function infoByMobile($mobile, $field = true)
    {
        /* 获取分类信息 */
        $map = array();
        $map['mobile'] = $mobile;
       

        $members=$this->field($field)->where($map)->select();
       
       foreach ($members as $key => $member) {
            $notice.="/:sun员工编号：".$member['id']." \n";
            $notice.="/:sun微信编号：".$member['userid']." \n";
            $notice.="/:sun手机号：". ($member['mobile']?$member['mobile']:'未完善信息')." \n";
            $notice.="/:sun持卡人：". ($member['remark']?$member['remark']:$member['name'])." \n";
            $notice.="/:sun账户余额：".($member['amount']?$member['amount']:0)."元 ";
            // $notice.="/:sun ".'<a href="http://'.$_SERVER[HTTP_HOST].U('Qwechat/index/editMy',array('userid'=>$wechatMember['userid'])).'">更改我的资料</a>';
       
           
       }
       
        
        return $notice;
    }




    public function editData($data)
    {
        $data=$this->create();
        
        if($data['id']){
            $res=$this->save($data);
        }else{
            $data['aid']=session('user_auth.aid');
            $res=$this->add($data);
        }
        return $res;
    }

    public function getBirthday($day,$field='name,birthday,calendar')
    {
      
        // 获得今年生日时间戳
        $current_birthday   = "UNIX_TIMESTAMP(concat(YEAR(NOW()),FROM_UNIXTIME(birthday,'-%m-%d')))";
        // 获得来年生日时间戳
        $next_birthday      = "UNIX_TIMESTAMP(concat(YEAR(NOW())+1,FROM_UNIXTIME(birthday,'-%m-%d')))";

        // 7 天 = 604800 秒
        // 条件一 今年生日(非跨年)的情况     语句为: $current_birthday - UNIX_TIMESTAMP() <= 604800 
        // 条件二 来年生日(跨年)的情况      语句为: $next_birthday - UNIX_TIMESTAMP() <= 604800 

        // 减去当前时间戳
        $subtrSql           = ' - UNIX_TIMESTAMP() <='.$day*3600*24;
        //条件语句为
        $whereSql           = $current_birthday.$subtrSql.' OR '.$next_birthday.$subtrSql;

        $birthdays  = $this->field($field)->where($whereSql)->select();
      
        $calendar=array('阴历','农历');
        foreach ($birthdays as $key => $birthday) {
           $birthdays[$key]['calendar']=$calendar[$birthday['calendar']];
        }
        
        return $birthdays;

    }

    

   
}
