<?php
/**
 * Created by: Jiar
 * Github: https://www.github.com/Jiar/
 */

namespace Qwechat\Model;

use Think\Model;

class AdminModel extends Model {
    
    protected $patchValidate = ture;
    protected $_validate = array(
        array('name','4,20','用户名长度范围:4~20',self::EXISTS_VALIDATE,'length'),
        array('name','checkName','该用户名已被使用',self::MODEL_BOTH,'callback'),
        array('email','email','未输入邮箱或格式错误'),
        array('email','checkEmail','该邮箱已被使用',self::MODEL_BOTH,'callback'),
        array('password','6,30','密码长度:6~30',self::EXISTS_VALIDATE,'length'),
        array('password','repassword','两次密码输入不一致',self::EXISTS_VALIDATE,'confirm'),
    );
    protected $autoCheckFields = true;
    protected $_auto = array(
        array('password', 'sha1', self::MODEL_BOTH, 'function'),
    );

    protected $_scope = array(

    );

    protected function checkName($name) {
        if($this->getAdminByName($name)) {
            return false;
        }
        return true;
    }

    protected function checkEmail($email) {
        if($this->getAdminByEmail($email)) {
            return false;
        }
        return true;
    }

    private function getAdminByName($name) {
        $admin = D("Admin");
        $result = $admin->getByName($name);
        if(count($result) == 0) {
            return null;
        } else {
            $result['password'] = null;
            return $result;
        }
    }

    private function getAdminByEmail($email) {
        $admin = D("Admin");
        $result = $admin->getByEmail($email);
        if(count($result) == 0) {
            return null;
        } else {
            $result['password'] = null;
            return $result;
        }
    }

}

