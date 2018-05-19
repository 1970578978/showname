<?php
namespace app\Controllers;

use fastFrame\base\Controller;
use app\Models\Ch_perinforModel;
use usefunction\ch_perinfor;

/**
 * 更改个人信息控制器
 * 在合适的条件下用来更改个人信息
 * @method change_prinfo 更改个人信息方法
 */
class Ch_perinforController extends Controller {
    /**
     * 更改个人信息方法
     * 
     * @param $id 用户主键
     * @param $openid wechat_id
     * @param $school 用户学校
     * @param $scholar 学号
     * @param $name 姓名
     * @param $class_num 班级
     * 
     * @return 输出是否成功的状态，并把错误信息输出来
     */
    public function change_prinfo($id="",$openid="",$school="",$scholar="",$name="",$class_num=""){

        $chk_obj = new ch_perinfor;
        $chkM_obj = new Ch_perinforModel;

        //先检测各个参数的格式是不是正确
        $c_msg = $chk_obj->check_data($id,$openid,$school,$scholar,$name,$class_num);
        $this->check_err($c_msg);

        //检测账号是不是正确
        $is_user = $creM_obj->check_user($id,$openid);
        $this->check_err($is_user);

        //更改数据库
        $chkM_obj->up_user($id,$openid,$school,$scholar,$name,$class_num);

        $r_msg['isok'] = true;
        
        return $r_msg;

    }
}