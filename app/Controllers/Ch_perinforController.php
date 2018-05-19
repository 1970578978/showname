<?php
namespace app\Controllers;

use fastFrame\base\Controller;
use app\Models\Ch_perinforModel;
use usefunction\ch_perinfor;

/**
 * 更改个人信息控制器
 * 在合适的条件下用来更改个人信息
 */
class Ch_perinforController extends Controller {
    /**
     * 更改个人信息方法
     * 
     * @param $id 用户主键
     * @param $school 用户学校
     * @param $scholar 学号
     * @param $name 姓名
     * @param $class_num 班级
     * 
     * @return 输出是否成功的状态，并把错误信息输出来
     */
    public function change_prinfo($id="",$school="",$scholar="",$name="",$class_num=""){

        $chk_obj = new ch_perinfor;
        $chkM_obj = new Ch_perinforModel;

        //先检测各个参数的格式是不是正确
        $c_msg = $chk_obj->check_data($id,$school,$scholar,$name,$class_num);
        if(array_key_exists('errMsg',$c_msg)){
            $c_msg['isok'] = false;
            $this->output($c_msg);
            die;
        }
        
    }
}