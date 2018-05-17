<?php
namespace app\models;

use fastFrame\base\Model;
use fastFrmae\db\Db;

class checkedModel extends Model {

    /**
     * 自定义当前模型操作的数据库表名称，
     * 如果不指定，默认为类名称的小写字符串，
     * 这里就是 item 表
     * @var string
     */
    protected $table = 'checked';


    /**
     * 查找签到口令对应的签到实列
     * 
     * @param $pawd 签到实列口令
     * @return array 有效的签到实列
     */
    public function slc_name($pawd){
        $sw_name = array("password"=>$pawd,"status"=>1);

        $sr_name = $this->select_all('create_name',array("*"),$sw_name);

        if(empty($sr_name)){
            $r_msg['errMsg'] = '签到口令错误';
            $r_msg['isok'] = false;
        }else{
            $r_msg['msg'] = $sr_name;
            $r_msg['isok'] = true;
        }

        return $r_msg;
    }


    /**
     * 查找签到者是不是已经签到了
     * 
     * @param $u_id 用户表的主键
     * @param $name_id 点名实列主键
     * @return array 签到者是否已经签到以及错误信息
     */
    public function is_checked($u_id,$name_id){
        $sw_checked = array("name_id"=>$name_id,"u_id"=>$u_id);

        $sr_checked = $this->select_all($this->table,array('id'),$sw_checked);

        if(empty($sr_checked)){
            $r_msg['isok'] = true;
        }else{
            $r_msg['errMsg'] = '你已经签过到，无法再次签到';
            $r_msg['isok'] = false;
        }

        return $r_msg;
    }

    /**
     * 查找签到者个人信息是不是完整
     * 
     * @param $u_id 用户表的主键
     * @return array 签到者的个人信息完整程度
     */
    public function slc_user($u_id){
        $sw_user = array("id"=>$u_id);

        $sr_user = $this->select_all("user_wechat",array("*"),$sw_user);

        if(empty($sr_user)){
            $r_msg['errMsg'] = '用户查找不到';
            $r_msg['isok'] = false;
        }else{
            if(empty($sr_user[0]['name'])){
                $r_msg['errMsg'] = '用户信息不完整';
                $r_msg['isok'] = false;
            }else{
                $r_msg['msg'] = $sr_user[0];
                $r_msg['isok'] = true;
            }
        }

        return $r_msg;
    }

    /**
     * 插入数据库实现签到
     * 
     * @param $name_id 从签到实列变里找出来的id
     * @param $user_ary 从用户表里找出来的数据
     * @param $mile 计算出的距离
     * @return boolean 插入成功就返回true 失败就false
     */
    public function checked($name_id,$user_ary,$long,$lat,$mile){

        //检测数据是不是空，空就赋一个值避免报错
        $school = empty($user_ary['school']) ? array() : array("school"=>$user_ary['school']);
        $grade = empty($user_ary['grade']) ? array() : array("grade"=>$user_ary['grade']);
        $schloar = empty($user_ary['scholar']) ? array() : array("scholar"=>$user_ary['scholar']);
        $profession = empty($user_ary['profession']) ? array() : array("profession"=>$user_ary['profession']);
        $class_num = empty($user_ary['class_num']) ? array() : array("class_num"=>$user_ary['class_num']);
        
        $ic_checked = array("name_id"=>$name_id,"u_id"=>$user_ary['id'],"name"=>$user_ary['name'],"longtitude"=>$long,
        "latitude"=>$lat,"mile"=>$mile);
        
        $ic_checked = array_merge($ic_checked,$school,$grade,$schloar,$profession,$class_num);

        $checked = $this->insert($this->table,$ic_checked);

        if(is_numeric($checked)){
            return $checked;
        }else{
            return false;
        }
    }

}