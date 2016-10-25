<?php
/**
 * Created by: Jiar
 */

namespace Qwechat\Controller;

use Think\Controller;

/**
 * 企业微信后台管理控制器
 */
class AdminController extends Controller {

    // 进入主界面
    public function admin_action() {
        if(session('?adminId') && session('?adminToken')) {
            redirect(U('Qwechat/qwechat'));
        } else {
            redirect(U('Admin/login'));
        }
    }

    // 进入登录、注册界面
    public function login_action() {
        if(session('?adminId') && session('?adminToken')) {
            redirect(U('Admin/admin'));
        } else {
            $this->display('login');
        }
    }

    // 进入注册界面
    public function register_action() {
        if(session('?adminId') && session('?adminToken')) {
            redirect(U('Admin/admin'));
        } else {
            $this->display('register');
        }
    }

    // 登录操作
    public function signin_action() {
        if(session('?adminId') && session('?adminToken')) {
            redirect(U('Admin/admin'));
        } else {
            $account = I('post.account');
            $password = sha1(I("post.password"));
            if(filter_var($account, FILTER_VALIDATE_EMAIL)) {
                // 邮箱登录
                $data['email'] = $account;
                $data['password'] = $password;
                $result = D('Admin')->where($data)->select();
                $result = $result[0];
                if(count($result) == 0) {
                    $this->error('该账户不存在');
                    return;
                }
                if($result['is_examine'] == 0) {
                    $this->error('该账户还在审核中，请耐心等待');
                    return;
                } else if($result['is_examine'] == 2) {
                    $this->error('该账户审核被拒绝，您可以重新注册');
                    return;
                }
                if($result['is_block'] == 1) {
                    $this->error('该账户已被屏蔽');
                    return;
                }
                $this->saveDataBySignin($result);
            } else {
                // 用户登录
                $data['name'] = $account;
                $data['password'] = $password;
                $result = D('Admin')->where($data)->select();
                $result = $result[0];
                if(count($result) == 0) {
                    $this->error('该账户不存在');
                    return;
                }
                if($result['is_examine'] == 0) {
                    $this->error('该账户还在审核中，请耐心等待');
                    return;
                } else if($result['is_examine'] == 2) {
                    $this->error('该账户审核被拒绝，您可以重新注册');
                    return;
                }
                if($result['is_block'] == 1) {
                    $this->error('该账户已被屏蔽');
                    return;
                }
                $this->saveDataBySignin($result);
            }
        }
    }

    // 注册操作
    public function signup_action() {
        $name = I('post.name');
        $data['name'] = $name;
        $data['password'] = I('post.password');
        $data['repassword'] = I('post.repassword');
        $data['email'] = I('post.email');
        $data['token'] = sha1('TOKEN:' .$name .date('YmdHis'));
        $data['create_time'] = date('Y-m-d H:i:s');
        $data['last_modify_time'] = date('Y-m-d H:i:s');
        $data['last_login_time'] = date('Y-m-d H:i:s');
        $id = $this->getExamineRefuseId($data['name'], $data['email']);
        if($id) {
            $admin = D("Admin");
            $admin->delete($id);
        }
        $admin = D('Admin');
        if (!$admin->create($data)){
            $this->error(structureErrorInfo($admin->getError()));
        } else {
            $admin->add();
            redirect(U('Admin/login'));
        }
    }

    // 退出操作
    public function signout_action() {
        session('[destroy]');
        session('[regenerate]');
        cookie('name',null);
        cookie('avatar',null);
        redirect(U('Admin/login'));
    }

    // 登录后保存session和cookie
    private function saveDataBySignin($result) {
        if(count($result) != 0) {
            $id = $result['id'];
            $data['id'] = $id;
            $data['token'] = sha1('TOKEN:' .$result['name'] .date('YmdHis'));
            $data['last_login_time'] = date('Y-m-d H:i:s');
            D('Admin')->save($data);
            $result = D('Admin')->select($id);
            $result = $result[0];
            session('adminId', $result['id']);
            session('adminToken', $result['token']);
            cookie('name',$result['name']);
            cookie('avatar',$result['avatar']);
            redirect(U('Admin/admin'));
        } else {
            $this->error('账户或密码错误');
        }
    }

    // 检查注册信息中的name、email是否是审核被拒绝的管理员，如果是，返回id
    private function getExamineRefuseId($name, $email) {
        $admin = D("Admin");
        $result = $admin->getByName($name);
        if(count($result) != 0) {
            if($result['is_examine'] == 2) {
                return $result['id'];
            }
        }
        $admin = D("Admin");
        $result = $admin->getByEmail($email);
        if(count($result) != 0) {
            if($result['is_examine'] == 2) {
                return $result['id'];
            }
        }
        return false;
    }

}