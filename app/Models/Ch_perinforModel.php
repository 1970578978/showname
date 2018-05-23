<?php
namespace app\Models;

use fastFrame\base\Model;
use fastFrmae\db\Db;

/**
 * 更改信息接口
 * 
 * @method up_user更改信息
 */
class Ch_perinforModel extends Model {
    /**
     * 自定义当前模型操作的数据库表名称，
     * 如果不指定，默认为类名称的小写字符串，
     * 这里就是 user_wechat 表
     * @var string
     */
    protected $table = 'user_wechat';

    /**
     * 更改用户信息
     * 
     * @param $id 用户主键
     * @param $openid 
     * @param $school 用户学校
     * @param $scholar 学号
     * @param $name 姓名
     * @param $class_num 班级
     */
    public function up_user($id,$openid,$school,$scholar,$name,$class_num){
        $uc_user = array("school"=>$school,"scholar"=>$scholar,"name"=>$name,"class_num"=>$class_num);
        $uw_user = array("id"=>$id);

        $this->update($this->table,$uc_user,$uw_user);
    }

    /**
     * 查找id和nameid是不是匹配
     * @param $id
     * @param $nameid
     * @return bollean 
     */
    public function sc_idandnameid($id,$nameid){
        $sw_name = array("id"=>$nameid,"u_id"=>$id);
        $sr_name = $this->select_all("create_name",array("*"),$sw_name);

        if(empty($sr_name)){
            $r_msg = array("errMsg"=>"你无法更改");
        }else{
            $r_msg = array();
        }

        return $r_msg;
        
    }

    /**
     * 终止签到
     * @param $nameid
     * @param $time
     * @return boolean
     */
    public function up_closename($nameid,$time){
        $uw_name = array("id"=>$nameid);

        if(empty($time)){           
            $uc_name = array("status"=>0);          
        }else{
            $uc_name = array("status"=>0,"time_limit"=>$time);
        }

        $this->update("create_name",$uc_name,$uw_name);
    }
}