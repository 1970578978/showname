<?php
namespace usefunction;

/**
 * 获取信息接口要用的通用方法
 */
class getmessage {

    /**
     * 检查获取个人信息方法参数情况
     * @param $id user表id
     * @param $openid
     * @return 不规范返回errmsg
     */
    public function checkParam_prmsg($id,$openid){
        $r_checkmsg = array();

        //检查id
        if(is_numeric($id)){

        }else{
            $r_checkmsg['errMsg'][0] = 'id格式不正确';
        }

        //检测openid参数
        if(empty($openid)){
            $r_checkmsg['errMsg'][6] = 'openid参数不能为空';
        }

        return $r_checkmsg;

    }

    /**
     * 检查获取签到者个人信息参数
     * @param nameid 参数id
     * @return 不规范就返回errmsg
     */
    public function checkChecked_msg($nameid){
        $r_checkmsg = array();

        //检查id
        if(is_numeric($nameid)){

        }else{
            $r_checkmsg['errMsg'][0] = 'id格式不正确';
        }

        return $r_checkmsg;
    }
}