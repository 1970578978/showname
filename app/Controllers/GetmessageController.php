<?php
namespace app\Controllers;

use fastFrame\base\Controller;
use app\Models\GetmessageModel;
use usefunction\getmessage;

/**
 * 获取信息的接口
 * @method personMessage 获取个人用户数据的接口
 */
class GetmessageController extends Controller {

    /**
     * 获取个人数据方法
     * 
     * @param $id 主键
     * @param $openid 唯一标示符
     */
    public function personMessage($id="",$openid=""){

        $cre_obj = new getmessage;
        $creM_obj = new GetmessageModel;

        //检查参数是不是合规
        $c_checkmsg = $cre_obj->checkParam_prmsg($id,$openid);
        $this->check_err($c_checkmsg);

        //检查账户是不是对应
        $is_user = $creM_obj->check_user($id,$openid);
        $this->check_err($is_user);

        //查找用户信息并输出
        $r_userMssage = $creM_obj->slc_userMessage($id);

        $this->output($r_userMssage);
    }

    /**
     * 查找签到的其他签到人的信息
     * 
     * @param $name_id 主键
     * @param $openid 唯一标示符
     * @param $data
     */
    public function username_data($name_id=""){

        //检测name——id是不是规范
        $cre_obj = new getmessage;
        $creM_obj = new GetmessageModel;

        //检测参数是不是规范
        $c_checkmsg = $cre_obj->checkChecked_msg($name_id);
        $this->check_err($c_checkmsg);

        //查找信息
        $checked_msg = $creM_obj->slc_checkedMessage($name_id);

        $this->output($checked_msg);
    }
}