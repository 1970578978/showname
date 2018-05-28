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

    /**
     * 检查获取时间参数的格式
     * @param $year
     * @param $month
     * @return 返回错误信息
     */
    public function checkDate_msg($id,$openid,$year,$month,$day){
        $r_checkmsg = array();

        //检查id
        if(is_numeric($id)){

        }else{
            $r_checkmsg['errMsg'][0] = 'id格式不正确';
        }

        //检测openid参数
        if(empty($openid)){
            $r_checkmsg['errMsg'][1] = 'openid参数不能为空';
        }
        
        //检查年
        if(is_numeric($year) && is_numeric($month) && is_numeric($day)){

        }else{
            $r_checkmsg['errMsg'][2] = '年月日格式不正确';
        }

        return $r_checkmsg;
    }

    /**
     * 获取当月的第一天是星期几
     * @param $year
     * @param $month
     * @return 返回的数据格式
     */
    public function getoneData($year,$month){
        //整形
        $year = (int)$year;
        $month = (int)$month;
        
        $d = mktime(0,12,30,$month,1,$year);
        //0表示星期天，1表示星期一
        $week = date("w",$d);
        //组合一个月有多少天
        $monthd = (int)date("t",$d);
    
        //计算空格值
        if($week == 0){
            $spaceNum = 6;
        }else{
            $spaceNum = $week-1;
        }

        //计算是不是当月是的话就计算
        date_default_timezone_set("PRC");
        $nowtime = date("Y.m.d",time());
        //以小数点的形式分开年月日
        $dateArray = explode(".",$nowtime);
        if($dateArray[0] == $year && $dateArray[1] == $month){
            $day = (int)$dateArray[2];
        }else{
            $day = (int)$monthd;
        }

        $r_msg = array("spaceNum"=>$spaceNum,"year"=>$year,"month"=>$month,"day"=>$day,"monthNum"=>$monthd);
        
        return $r_msg;
    }

    /**
     * 签到数据的处理和整合
     * @param $msg 用模型获取到的数据
     */
    public function dealmsg_checked($msg){
        $r_msg = array();

        foreach($msg as $key=>$value){
            //获取年参数
            $date = explode(" ",$value['createtime']);
            $big_date = explode("-",$date[0]);
            $small_date = explode(":",$date[1]);

            $year = (int)$big_date[0];
            if(!isset($years_data[$year])){
                $years_data[$year] = array();

                $month = $big_date[1];
                if(!isset($years_data[$year][$month])){
                    $years_data[$year][$month] = array();

                    $day = $big_date[2];
                    if(!isset($years_data[$year][$month][$day])){
                        $years_data[$year][$month][$day] = array();

                        //细化到一天的数据
                        $time_hour = $small_date[0].":".$small_date[1];

                        if($value['mile'] > 150){
                            $years_data[$year][$month][$day]['TIMECONTENT'][] = array("TIMETITLE"=>$time_hour,"className"=>$value['classname'],"uSuccess"=>false);
                        }else{
                            $years_data[$year][$month][$day]['TIMECONTENT'][] = array("TIMETITLE"=>$time_hour,"className"=>$value['classname'],"uSuccess"=>true);
                        }

                    }else{
                        //细化到一天的数据
                        $time_hour = $small_date[0].":".$small_date[1];

                        if($value['mile'] > 150){
                            $years_data[$year][$month][$day]['TIMECONTENT'][] = array("TIMETITLE"=>$time_hour,"className"=>$value['classname'],"uSuccess"=>false);
                        }else{
                            $years_data[$year][$month][$day]['TIMECONTENT'][] = array("TIMETITLE"=>$time_hour,"className"=>$value['classname'],"uSuccess"=>true);
                        }
                    }

                }else{
                    $day = $big_date[2];
                    if(!isset($years_data[$year][$month][$day])){
                        $years_data[$year][$month][$day] = array();

                        //细化到一天的数据
                        $time_hour = $small_date[0].":".$small_date[1];

                        if($value['mile'] > 150){
                            $years_data[$year][$month][$day]['TIMECONTENT'][] = array("TIMETITLE"=>$time_hour,"className"=>$value['classname'],"uSuccess"=>false);
                        }else{
                            $years_data[$year][$month][$day]['TIMECONTENT'][] = array("TIMETITLE"=>$time_hour,"className"=>$value['classname'],"uSuccess"=>true);
                        }

                    }else{
                        //细化到一天的数据
                        $time_hour = $small_date[0].":".$small_date[1];

                        if($value['mile'] > 150){
                            $years_data[$year][$month][$day]['TIMECONTENT'][] = array("TIMETITLE"=>$time_hour,"className"=>$value['classname'],"uSuccess"=>false);
                        }else{
                            $years_data[$year][$month][$day]['TIMECONTENT'][] = array("TIMETITLE"=>$time_hour,"className"=>$value['classname'],"uSuccess"=>true);
                        }
                    }

                }

            }else{
                $month = $big_date[1];
                if(!isset($years_data[$year][$month])){
                    $years_data[$year][$month] = array();

                    $day = $big_date[2];
                    if(!isset($years_data[$year][$month][$day])){
                        $years_data[$year][$month][$day] = array();

                        //细化到一天的数据
                        $time_hour = $small_date[0].":".$small_date[1];

                        if($value['mile'] > 150){
                            $years_data[$year][$month][$day]['TIMECONTENT'][] = array("TIMETITLE"=>$time_hour,"className"=>$value['classname'],"uSuccess"=>false);
                        }else{
                            $years_data[$year][$month][$day]['TIMECONTENT'][] = array("TIMETITLE"=>$time_hour,"className"=>$value['classname'],"uSuccess"=>true);
                        }

                    }else{
                        //细化到一天的数据
                        $time_hour = $small_date[0].":".$small_date[1];

                        if($value['mile'] > 150){
                            $years_data[$year][$month][$day]['TIMECONTENT'][] = array("TIMETITLE"=>$time_hour,"className"=>$value['classname'],"uSuccess"=>false);
                        }else{
                            $years_data[$year][$month][$day]['TIMECONTENT'][] = array("TIMETITLE"=>$time_hour,"className"=>$value['classname'],"uSuccess"=>true);
                        }
                    }

                }else{
                    $day = $big_date[2];
                    if(!isset($years_data[$year][$month][$day])){
                        $years_data[$year][$month][$day] = array();

                        //细化到一天的数据
                        $time_hour = $small_date[0].":".$small_date[1];

                        if($value['mile'] > 150){
                            $years_data[$year][$month][$day]['TIMECONTENT'][] = array("TIMETITLE"=>$time_hour,"className"=>$value['classname'],"uSuccess"=>false);
                        }else{
                            $years_data[$year][$month][$day]['TIMECONTENT'][] = array("TIMETITLE"=>$time_hour,"className"=>$value['classname'],"uSuccess"=>true);
                        }

                    }else{
                        //细化到一天的数据
                        $time_hour = $small_date[0].":".$small_date[1];

                        if($value['mile'] > 150){
                            $years_data[$year][$month][$day]['TIMECONTENT'][] = array("TIMETITLE"=>$time_hour,"className"=>$value['classname'],"uSuccess"=>false);
                        }else{
                            $years_data[$year][$month][$day]['TIMECONTENT'][] = array("TIMETITLE"=>$time_hour,"className"=>$value['classname'],"uSuccess"=>true);
                        }
                    }

                }
            }
        }

        $r_msg_year = array();
         foreach($years_data as $year=>$year_data){
            $r_msg_month = array();

            foreach($year_data as $month=>$month_data){
                $r_msg_day = array();

                foreach($month_data as $day=>$day_data){
                    
                    $daymsg['DAYTITLE'] = $day."日";
                    $daymsg['TIMECONTENT'] = $day_data['TIMECONTENT'];

                    $r_msg_day[] = $daymsg;
                    
                    
                }
                $monthmsg['MONTHTITLE'] = $month."月";

                $monthmsg['DAYCONTENT'] = $r_msg_day;
               
                $r_msg_month[] = $monthmsg;
                
            }
            $yearmsg['YEARTITLE'] = $year;

            $yearmsg['MONTHCONTENT'] = $r_msg_month;

            $r_msg_year[] = $yearmsg;

        }
        

        $r_msg = array('SignedRecord'=>$r_msg_year);
        return $r_msg;
    }

}