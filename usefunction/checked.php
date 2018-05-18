<?php
namespace usefunction;

/**
 * 实现签到的数据处理方法集合类
 */
class checked {
    /**
     * 先检查参数格式是不是正确
     * @param $u_id 签到者在用户表的主键
     * @param $pawd 签到口令
     * @param $long 经度
     * @param $lat 纬度
     * @return array 检查的一些错误信息，如果没有就是空数组
     */
    public function check_data($u_id,$pawd,$long,$lat){
        $r_mesg =array();

        if(is_numeric($u_id)){

        }else{
            $r_mesg['errMsg'][0] = 'id格式不正确';
        }

        if(mb_strlen($pawd)>4 || mb_strlen($pawd)!=strlen($pawd) || empty($pawd)){
            $r_mesg['errMsg'][1] = '签到口令不正确';
        }
        
        //检查经纬度的精度是不是合要求 
        if(is_float($long)){
            $long_1 = explode(".",$long);
            if(strlen($long_1[1])<3){
                $r_mesg['errMsg'][2] = '经度参数不够精确';
            }
        }else{
            $r_mesg['errMsg'][2] = '经度参数不是经度';
        }

        if(is_float($lat)){
            $lat_1 = explode(".",$lat);
            if(strlen($lat_1[1])<3){
                $r_mesg['errMsg'][3] = '纬度参数不够精确';
            }
        }else{
            $r_mesg['errMsg'][3] = '纬度参数不是纬度';
        }

        return $r_mesg;
    }


    /**
     * 检查签到实列是不是在签到者最近的区域
     * 
     * @param $long 签到者的经度
     * @param $lat 签到者的纬度
     * @param $max_lg 最大的经度
     * @param $min_lg 最小经度
     * @param $max_la 最大纬度
     * @param $min_la 最小纬度
     * @return boolean 在范围内就返回true，不在就返回false
     */
    public function check_ranK($long,$lat,$max_lg,$min_lg,$max_la,$min_la){
        if($long<=$max_lg && $long>=$min_lg && $lat<=$max_la && $lat>=$min_la){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 计算签到者和发起签到者之间的距离
     * 
     * @param $lng1  ,lng2 经度
     * @param $lat1  ,lat2 纬度
     * @return float 距离，单位米
     * @author www.Alixixi.com 
     */
    public function getdistance($lng1, $lat1, $lng2, $lat2) {
        // 将角度转为狐度
        $radLat1 = deg2rad($lat1); //deg2rad()函数将角度转换为弧度
        $radLat2 = deg2rad($lat2);
        $radLng1 = deg2rad($lng1);
        $radLng2 = deg2rad($lng2);
        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6378.137 * 1000;

        //取整
        $s = (int)floor($s);
        return $s;
    } 
}