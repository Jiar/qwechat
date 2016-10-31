<?php
/**
 * Created by: Jiar
 * Github: https://www.github.com/Jiar/
 */

namespace Qwechat\Model;

use Think\Model;
use Qwechat\Sdk\TPWechat;
use Qwechat\Sdk\errCode;

class QwechatDepartmentModel extends Model {
  
  protected $patchValidate = ture;
  protected $_validate = array(
    array('name','require','应用名称不能为空', self::EXISTS_VALIDATE),
    array('name', '0,100', '应用名称太长', self::EXISTS_VALIDATE, 'length'),
    array('id','number','id必须为数字', self::EXISTS_VALIDATE),
    array('parentid','number','parentid必须为数字', self::EXISTS_VALIDATE),
    array('order','number','order必须为数字', self::EXISTS_VALIDATE),
  );


  /********************** Controller's Function 对应 Model 操作 -start **********************/

  /**
   * 从数据库中获取所有部门，若数据库中没有部门数据，则从微信企业号获取。
   *
   * @return 部门集合 
   * array('id'=>'value', 'parentid'=>'value', 'name'=>'value', 'order'=>'value', 'aid'=>'value', 'subDepartments'=>array())
   */
  public function departmentManage($reFetch = false) {
    if($reFetch || D('QwechatDepartment')->Count() == 0) {
      $this->getDepartmentFromQwechatToSave();
    }
    return $this->structureDepartment();
  }

  /**
   * 添加子部门
   * 
   * @param $sup_department_id   父类部门Id
   * @param $sub_department_name 需要添加的部门的名字
   */
  public function createSubDepartment($sup_department_id, $sub_department_name) {
    $weObj = TPWechat::getInstance();
    $data['parentid'] = $sup_department_id;
    $data['name'] = $sub_department_name;
    return $weObj->createDepartment($data);
  }

  /**
   * 更新部门信息
   * 
   * @param $department_id   父类部门Id
   * @param $department_name 需要添加的部门的名字
   *
   * @return 是否更新成功
   */
  public function updateDepartment($department_id, $department_name) {
    $weObj = TPWechat::getInstance();
    $data['id'] = $department_id;
    $data['name'] = $department_name;
    trace('department_id:', $department_id);
    trace('department_name:', $department_name);
    return $weObj->updateDepartment($data);
  }

  /**
   * 删除部门
   * 
   * @param  $department_id  需要删除的部门Id
   * 
   * @return 是否删除成功
   */
  public function deleteDepartment($department_id) {
    $weObj = TPWechat::getInstance();
    trace('department_id:', $department_id);
    return $weObj->deleteDepartment($department_id);
  }

  /********************** Controller's Function 对应 Model 操作 -end **********************/


  /********************** private -start **********************/

  /**
   * 从微信企业号后台请求所有部门存储到本地数据库
   */
  private function getDepartmentFromQwechatToSave() {
    $departments = $this->getDepartmentFromQwechat();
    $departments = $departments['department'];
    foreach ($departments as $department) {
      if(M("QwechatDepartment")->find($department['id'])) {
        M("QwechatDepartment")->save($department);
      } else {
        M("QwechatDepartment")->add($department);
      }
    }
  }

  /**
   * 从微信企业号后台请求所有部门
   * 
   * @return 所有部门
   */
  private function getDepartmentFromQwechat() {
    $weObj = TPWechat::getInstance();
    return $weObj->getDepartment();
  }

  /**
   * 准备构建部门树状集合
   * 
   * @return 部门树状集合
   */
  private function structureDepartment() {
    $rootDepartment['id'] = 0;
    $this->recursionDepartment($rootDepartment);
    $rootDepartment = $rootDepartment['subDepartments'];
    return $rootDepartment;
  }

  /**
   * 利用递归的方式，将部门按树状形式组合成多维数组
   * 
   * @param $rootDepartment 根部门
   */
  private function recursionDepartment(&$rootDepartment) {
    $where['parentid'] = $rootDepartment['id'];
    $temps = D("QwechatDepartment")->where($where)->order(array('id'=>'asc','order'=>'asc'))->select();
    $tempsCount = count($temps);
    //foreach形式循环是对数组的拷贝，想要用引用，必须用传统的for形式循环。
    for($i=0;$i<$tempsCount;$i++) {
      $this->recursionDepartment($temps[$i]);
    }
    $rootDepartment['subDepartments']= &$temps;
  }

  /********************** private -end **********************/

}
