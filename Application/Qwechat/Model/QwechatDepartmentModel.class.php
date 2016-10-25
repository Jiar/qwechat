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
   */
  public function departmentManage() {
    $departments = D('QwechatDepartment')->select();
    if(count($departments) == 0) {
      $departments = $this->getDepartmentFromQwechat();
      $departments = $departments['department'];
      foreach ($departments as $department) {
        echo $department;
        M("QwechatDepartment")->save($department);
      }
    }
    return $departments;
  }

  /********************** Controller's Function 对应 Model 操作 -end **********************/


  /********************** private -start **********************/

  /**
   * 从微信企业号后台请求所有部门
   * 
   * @return 所有部门
   */
  private function getDepartmentFromQwechat() {
    $weObj = TPWechat::getInstance();
    return $weObj->getDepartment();
  }

  /********************** private -end **********************/


  /********************** old functions -start **********************/

    public function updateDepartment($department=array()) {
       
        $map['id']=$department['id'];
        $map['aid']=session('user_auth.aid');
        $department['aid']=session('user_auth.aid');


      $have = M("QwechatDepartment")->where($map)->find();
      $data = $this->create($department);
      
        if ($have){
            $this->where($map)->save();
            return "update";
        }else{
            $this->add();
            return "add";
        }
    }

     /**获得分类树
     * @param int  $id
     * @param bool $field
     * @return array
     * @auth 陈一枭
     */
    public function getTree($id = 1, $field = true){
        /* 获取当前分类信息 */
        

        /* 获取所有分类 */
        $map['aid']=session('user_auth.aid');
        $map['status']= array('EGT', 0);
       
        $list = $this->field($field)->where($map)->order('`order`')->select(); 
         foreach ($list as $key => $value) {
            $map['department'] = array('like', '%' . $value['id'] . '%');
            $list[$key]['total']=D('QwechatMember')->where($map)->count('id');     
        }
       

        $list = list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_', $root = $id);
      
        /* 获取返回数据 */
        if(isset($info)){ //指定分类则返回当前分类极其子分类
            $info['_'] = $list;
        } else { //否则返回所有分类
            $info = $list;
        }

        return $info;
    }

      /**
     * 获取部门详细信息
     * @param $id
     * @param bool $field
     * @return mixed
     * @author 郑钟良<zzl@ourstu.com>
     */
    public function info($id, $field = true){
        /* 获取分类信息 */
        $map = array();
        if(is_numeric($id)){ //通过ID查询
            $map['id'] = $id;
        } else { //通过标识查询
            $map['name'] = $id;
        }
        $department=$this->field($field)->where($map)->find();
       
        
        return $department;
    }


     //传id 获取 子id
    public  function getData($map , $field='*' ){
      
    
      $map['status']= array('EGT', 0);
      $list = $this->where($map)->select(); 
      
      return $list;

    }

     public  function getChilds($map ,$father ,$ge=''){
      
    
      $list=$this->getData($map);
      $childs=$this->Childs($list,$father);
      array_push( $childs,$father) ;
      if ($ge) $childs=implode('|',$childs);

      return $childs;

    }



    //传id 获取 子id
    public  function Childs($list , $father ){
      
      
      $arr = array();
      foreach($list as $val){   
    
        if($val['parentid'] == $father){
          
          $arr[] = $val['id'];
          
          $arr = array_merge($arr , $this-> Childs($list , $val['id']));
          
        }
    
      }
      return $arr;

    }

/********************** old functions -end **********************/


}
