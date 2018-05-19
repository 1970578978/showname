<?php
namespace usefunction;

/**
 * 创建签到实列是调用的数据处理方法
 * 
 */
class create_name {

    /**
     * 生随机签到口令的方法
     * 
     * @return 随机的四位签到口令
     */
    public function set_password(){

        $key = "";
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';  

        for($i=0;$i<4;$i++)   
        {   
            $key .= $pattern{mt_rand(0,35)};    //生成php随机数   
        }   
        return $key;   
    }

    /**
     * 把一个经纬度生成范围内的经纬度(大概2000米的范围)
     * 
     * @param $lat 纬度
     * @param $lng 经度
     * @return array 包含最大和最小的经纬度数组
     */
    public function set_maxdegree($lng,$lat){
        $r_lng = array();

        $r_lng['max_longitude'] = $lng+0.02;
        $r_lng['min_longitude'] = $lng-0.02;
        $r_lng['max_latitude'] = $lat+0.02;
        $r_lng['min_latitude'] = $lat-0.02;
        
        return $r_lng;
    }


    /**
     * 检测建立签到实列的数据是不是规范
     * 
     * @param $p_id user表的主键
     * @param $p_in 签到的描述
     * @param $p_time 签到的有效时间
     * @param $p_num 签到应到人数
     * @param $p_long 签到者的经度
     * @param $p_lat 签到者的纬度
     * @return 规范就返回数据组合的数组方便插进数据库，不规范就返回errMsg
     */
    public function check_data($p_id,$openid,$p_in,$p_det,$p_num,$p_long,$p_lat){
        $r_checkmsg = array();

        //检测id参数
        if(is_numeric($p_id)){
            $r_checkmsg['u_id'] = $p_id;

        }else{
            $r_checkmsg['errMsg'][0] = "传的id参数不是数字";
        }

        //检测openid参数
        if(empty($openid)){
            $r_checkmsg['errMsg'][6] = 'openid参数不能为空';
        }

        //检测说明的位数
        if(mb_strlen($p_in)>20 || empty($p_in)){
            $r_checkmsg['errMsg'][1] = '填写课程超过20个字或者没有传递参数';
        }else{
            $r_checkmsg['instructions'] = $p_in;
        }

        //检测详情的参数
        if(mb_strlen($p_det)>50 || empty($p_det)){
            $r_checkmsg['errMsg'][5] = '填写的说明超过50个字或者没有传递参数';
        }else{
            $r_checkmsg['details'] = $p_det;
        }

        //检测应到人数的参数
        if(is_numeric($p_num)&&mb_strlen($p_num)<=6){
            $r_checkmsg['num_should'] = $p_num;
        }else{
            $r_checkmsg['errMsg'][2] = '应到人数请输入数字并且不要超过6位数';
        }

        //去小数位后检测经度
        

        if(strpos($p_long,".") && !empty($p_long)){
            $long = explode(".",$p_long);
            if(strlen($long[1])<3){
                $r_checkmsg['errMsg'][3] = '经度参数不够精确';
            }else{
                $r_checkmsg['longitude'] = $p_long;
            }
        }else{
            $r_checkmsg['errMsg'][3] = '经度参数不是经度';
        }

        if(strpos($p_lat,".") && !empty($p_lat)){
            $lat = explode(".",$p_lat);
            if(strlen($lat[1])<3){
                $r_checkmsg['errMsg'][4] = '纬度参数不够精确';
            }else{
                $r_checkmsg['latitude'] = $p_lat;
            }
        }else{
            $r_checkmsg['errMsg'][4] = '纬度参数不是纬度';
        }

        return $r_checkmsg;
    }
}