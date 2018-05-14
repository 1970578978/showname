<?php
namespace usefunction;

/**
 * 通过login得到的code获取openID
 */
class openidWay {
    public function getopenid($code){
        $api_url = "https://api.weixin.qq.com/sns/jscode2session?appid=".app_id."&secret=".app_secret."&js_code=$code&grant_type=authorization_code";

        //用file_get_contents方法获取数据
        $str = file_get_contents($api_url);

        //将json字符串转为数组
        $data = json_decode($str, true);
        return $data;
    }
}