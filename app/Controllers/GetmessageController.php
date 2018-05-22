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

    /**
     * 获取一年中每月的第一天是星期几
     * @param $id
     * @param $openid
     * @param $year
     * @param $month
     * 
     * @return 各种组合的数据
     */
    public function getmonthDay($id="",$openid="",$year="",$month="",$day=""){
        
        //检测name——id是不是规范
        $cre_obj = new getmessage;
        $creM_obj = new GetmessageModel;

        //如果没有传时间参数就获取当现在的时间
        if(empty($year) || empty($month) || empty($day)){
            date_default_timezone_set("PRC");
            $nowtime = date("Y.m.d",time());
            $dateArray = explode(".",$nowtime);
            $year = (int)$dateArray[0];
            $month = (int)$dateArray[1];
            $day = (int)$dateArray[2];
        }

        //检查参数
        $c_checkmsg = $cre_obj->checkDate_msg($id,$openid,$year,$month,$day);
        $this->check_err($c_checkmsg);

        //检查账号是不是对
        $is_user = $creM_obj->check_user($id,$openid);
        $this->check_err($is_user);

        //获取关于时间的一些数据
        $dateMeg = $cre_obj->getoneData($year,$month);

        $dateboolean = array();
        //查找某月的哪些天有发起签到
        for($i=0;$i<$dateMeg['day']-1;$i++){
            $is_msg = $creM_obj->slc_onedayData($id,$year,$month,$i+1);
            if($is_msg){
                $trueorfalse[$i] = false;
            }else{
                $trueorfalse[$i] = true;
            }
        }
        $dateboolean = array("theDayBool"=>$trueorfalse);

        //查找签到简略签到数据
        $onedatyMsg = $creM_obj->slc_onedayData($id,$year,$month,$day);
        $d = mktime(0,12,30,$month,$day,$year);         //制造时间戳
        $replacetime = date("Y-m-d",$d);        //要去掉的年月日字符串
        if(!empty($onedatyMsg)){
            foreach($onedatyMsg as $key=>$value){
                //去掉年月日和空格
                $ctime = str_replace(array(" ",$replacetime,"\n","\r","\r\n"),"",$value['createtime']);
                $simple_msg[$key]['time'] = $ctime;
                $simple_msg[$key]['majorNames'] = $value['details'];
                $simple_msg[$key]['signedNum'] = $value['num_should'];
                $simple_msg[$key]['studentsNum'] = $value['num_arrivals'];
                $simple_msg[$key]['classname'] = $value['instructions'];
                $simple_msg[$key]['name_id'] = $value['id'];
            }
        }else{
            $simple_msg = array();
        }
        $detailsArray = array("theDayRecords"=>$simple_msg);            //组合签到实列信息数据

        $r_msg = array($dateMeg,$dateboolean,$detailsArray);
        $this->output($r_msg);
    }
}