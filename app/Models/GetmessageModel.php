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
        return $user_message[0];
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
     * 查找某月的某一天是不是有数据
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
}