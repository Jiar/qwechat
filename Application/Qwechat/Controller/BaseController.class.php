<?php
/**
 * Created by: Jiar
 */

namespace Qwechat\Controller;
use Think\Controller;
use Qwechat\Sdk\TPWechat;
use Qwechat\Sdk\errCode;

/**
 * 基础控制器
 */
class BaseController extends Controller {
	
	function _initialize() {
        // if(!session('?adminId') || !session('?adminToken')) {
        //     $this->error('登录超时,请重新登录', U('Admin/Admin/login'));
        // }
        // $access = \Org\Util\Rbac::AccessDecision();
        // if(!$access) {
        //     $this->error('抱歉,您没有该权限');
        // }
    }

    public function index_action() {
        echo 'index';
    }
}