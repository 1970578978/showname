<?php
namespace app\Controllers;

use fastFrame\base\Controller;
use app\Models\CheckedModel;
use usefunction\checked;

/**
 * 签到接口控制器
 * 实现签到记录方法
 * 
 * @method showname进行签到的接口
 */
class CheckedController extends Controller {
    /**
     * 实现签到记录的方法
     * 
     * @param $u_id 用户表主键
     * @param $pawd 签到口令
     * @param $long 签到者经度
     * @param $lat 签到者纬度
     * 
     */
    public function showname($u_id="",$openid='',$pawd="",$long="",$lat="",$all_check=""){

        $chk_obj = new checked;
        $chkM_obj = new checkedModel;

        //先检查参数格式是不是正确
        $c_msg = $chk_obj->check_data($u_id,$openid,$pawd,$long,$lat);
        if(array_key_exists('errMsg',$c_msg)){
            $errMsg = "";
            //使errmsg对应的值字符串（做到前后统一）
            foreach($c_msg['errMsg'] as $key=>$value){
                $errMsg .= $value;
            }
            $rc_msg['errMsg'] = $errMsg;
            $rc_msg['isok'] = false;
            $this->output($rc_msg);
            die;
        }

        //检测用户id和openid是不是对应关系
        $is_user = $chkM_obj->check_user($u_id,$openid);
        if(array_key_exists('errMsg',$is_user)){
            $is_user['isok'] = false;
            $this->output($is_user);
            die;
        }

        //查找个人信息是不是完整 只对name做了要求
        $usr_msg = $chkM_obj->slc_user($u_id,$all_check);
        if(!$usr_msg['isok']){
            $this->output($usr_msg);
            die;
        }


        //查找出对应的签到实列
        $sname_msg = $chkM_obj->slc_name($pawd);
        if(!$sname_msg['isok']){
            $this->output($sname_msg);
            die;
        }

        //查找这个用户是不是已经签了到
        //先查找这个用户能不能在这个签到实列签到
        foreach($sname_msg['msg'] as $k=>$value){
            if($chk_obj->check_ranK($long,$lat,$value['max_longitude'],$value['min_longitude'],$value['max_latitude'],$value['min_latitude'])){
                $scheckde_msg = $chkM_obj->is_checked($u_id,$value['id']);
                //查看用户是不是已经签过到
                if(!$scheckde_msg['isok']){
                    $this->output($scheckde_msg);
                    die;
                }else{
                    //记录数组的建并且可以跳过循环，因为这个是唯一的
                    $can_key = $k;
                    break;
                }
            //如果最后一个也没在这个区域里
            }else{
                if($k == count($sname_msg['msg'])-1){
                    $scheckde_msg['errMsg'] = '在你所在的区域里没有发起这个签到';
                    $scheckde_msg['isok'] = false;
                    $this->output($scheckde_msg);
                    die;
                }else{
                    continue;
                }
            }
        }


        //计算签到者和发起签到者的距离 准备把签到插入数据库
        $mile = $chk_obj->getdistance($sname_msg['msg'][$can_key]['longitude'],$sname_msg['msg'][$can_key]['latitude'],$long,$lat);

        //把签到插入数据库
        $is_sucess = $chkM_obj->checked($sname_msg['msg'][$can_key]['id'],$usr_msg['msg'],$long,$lat,$mile);
        if($is_sucess){
            $r_msg['name_id'] = $sname_msg['msg'][$can_key]['id'];
            $r_msg['checked_id'] = $is_sucess;
            $r_msg['isok'] = true;
        }else{
            $r_msg['name_id'] = $sname_msg['msg'][$can_key]['id'];
            $r_msg['checked_id'] = null;
            $r_msg['isok'] = false;
        }

        //输出参数
        $this->output($r_msg);
    }
}
