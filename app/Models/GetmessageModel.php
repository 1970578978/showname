<?php
namespace app\Models;

use fastFrame\base\Model;
use fastFrmae\db\Db;

/**
 * 获取信息的摸版
 */
class GetmessageModel extends Model {

    /**
     * 自定义当前模型操作的数据库表名称，
     * 如果不指定，默认为类名称的小写字符串，
     * 这里就是 item 表
     * @var string
     */
    protected $table = 'user_wechat';

    /**
     * 查找个人信息用户数据
     * @param $id
     * @return 查找出来的用户信息
     */
    public function slc_userMessage($id){
        $sw_user = array("id"=>$id);
        $user_message = $this->select_all($this->table,array('*'),$sw_user);
        unset($user_message[0]['session_key']);

        //查找有多少签到和创建签到
        $checked_message = $this->select_all('checked',array('id'),array("u_id"=>$id));
        $user_message[0]['num_checked'] = (int)count($checked_message);

        $name_message = $this->select_all('create_name',array('id'),array("u_id"=>$id));
        $user_message[0]['num_create_name'] = (int)count($name_message);
        return $user_message[0];
    }

    /**
     * 查找签到实列的信息（例如签到口令）
     * @param $nameid
     * @return array 找到的信息组成的数组
     * 
     */
    public function slc_nameMsg($nameid){
        //把有数据都找出来，放在控制器组合
        $sw_named = array("id"=>$nameid);
        $name_message = $this->select_all("create_name",array("*"),$sw_named);

        return $name_message[0];
    }

    /**
     * 从数据库里面找出签到者信息
     * @param $nameid 签到实列id
     * @return 签到用户信息
     */
    public function slc_checkedMessage($nameid){
        //先查找签到表 表签到时候的个人信息取出来
        $sw_checked = array("name_id"=>$nameid);
        $checked_message = $this->select_all("checked",array('*'),$sw_checked);

        foreach($checked_message as $key=>$value){
            $sw_user = array('id'=>$value['u_id']);
            $user_avatar = $this->select_all("user_wechat",array('avatar'),$sw_user);
            $checked_message[$key]['avatar'] = $user_avatar[0]['avatar'];

        }

        
        return $checked_message;
        
    }

    /**
     * 查找某月的某一天是不是发起签到有数据
     * @param $id userid
     * @param $year 
     * @param $month
     * @param $day
     */
    public function slc_onedayData($id,$year,$month,$day){
        //用sql语句进行查找
        $slc_sqloneday = "SELECT * FROM create_name where year(createtime)=$year and month(createtime)=$month and day(createtime)=$day and u_id=$id";
        $oneday_msg = $this->select_sql($slc_sqloneday);

        if(empty($oneday_msg)){
            return false;
        }else{
            return $oneday_msg;
        }
    }

    /**
     * 查找签到者，签到历史记录消息
     * @param $id
     * 
     * @return 查找的签到数据
     */
    public function slc_chmsgfromchecked($id){
        $sw_checked = array("u_id"=>$id);
        $checked_message = $this->select_all("checked",array('*'),$sw_checked);

        foreach($checked_message as $key=>$value){
            $sw_named = array("id"=>$value['name_id']);
            $classname = $this->select_all("create_name",array('instructions'),$sw_named);
            $checked_message[$key]['classname'] = $classname[0]['instructions'];

        }

        return $checked_message;
    }
}