<?php
namespace usefunction;

/**
 * 更改用户信息时要用的一些通用方法
 */
class ch_perinfor {
    /**
     * 检测参数格式是不是正确
     * 
     * @param $id 用户主键
     * @param $school 用户学校
     * @param $scholar 学号
     * @param $name 姓名
     * @param $class_num 班级
     */
    public function check_data($id,$openid,$school,$scholar,$name,$class_num){
        $r_mesg =array();

        //检测id主键格式
        if(is_numeric($id)){

        }else{
            $r_mesg['errMsg'][0] = 'id格式不正确';
        }

        //检测openid
        if(empty($openid)){
            $r_mesg['errMsg'][5] = 'openid参数不能为空';
        }

        //检测学校名称
        if(mb_strlen($school)>30 || empty($school)){
            $r_mesg['errMsg'][1] = '学校名称太长或者为空';
        }

        //检测学号
        if(mb_strlen($scholar)>50 || empty($scholar)){
            $r_mesg['errMsg'][2] = '学号超过50个字符或者没有输入学号';
        }

        //检测姓名
        if(mb_strlen($name)>20 || empty($name)){
            $r_mesg['errMsg'][3] = '姓名超过20个字符或者没有输入姓名';
        }

        //检测班级
        if(mb_strlen($class_num)>20 || empty($class_num)){
            $r_mesg['errMsg'][4] = '班级超过20个字符或者没有输入班级';
        }

        return $r_mesg;
    }
}