<?php
namespace app\Controllers;

use fastFrame\base\Controller;
use app\Models\Create_nameModel;
use usefunction\create_name;


/**
 * 创建签到实列接口控制器
 * 包含创建方法create
 */
class create_nameController extends Controller {
    
    /**
     * 建立签到实列方法
     * 
     * @param $p_id 用户id
     * @param $p_in 签到描述
     * @param $P_num 签到应到人数
     * @param $p_long 发起签到经度
     * @param $p_lat 发起签到者纬度
     * 
     * @return 正常输出实列id 签到口令和状态码
     */
    public function create($p_id,$p_in,$p_det,$p_num,$p_long,$p_lat){
        
        $r_msg = array();
        //url偏码问题
        $p_in = urldecode($p_in);
        
        //把要用的通用方法实列话
        $cre_obj = new create_name;
        $creM_obj = new create_nameModel;

        //检测参数格式是不是正确
        $ic_checkmsg = $cre_obj->check_data($p_id,$p_in,$p_det,$p_num,$p_long,$p_lat);

        if(array_key_exists('errMsg',$ic_checkmsg)){
            //存在错误就输出来并终止程序的运行
            $ic_checkmsg['errMsg']['isok'] = false;
            $this->output($ic_checkmsg['errMsg']);
            die;
        }


        //用循环检测的方式检测口令是不是可用
        while(true){
            //生成随机签到口令
            $name_password = $cre_obj->set_password();
            
            //调用模型检查方法
            $is_password = $creM_obj->check_paswd($name_password);

            //如果存在的话就进行二次检验
            if($is_password['isok']){
                
                break;
            }else{
                foreach($is_password['mesg'] as $k=>$value){
                    $max_long = $value['max_longitude']+0.02;
                    $min_long = $value['min_longitude']-0.02;

                    $max_lat = $value['max_latitude']+0.02;
                    $min_lat = $value['min_latitude']-0.02;

                    //判断这个点在这个范围内
                    if($p_long<$max_long && $p_long>$min_long && $p_lat>$min_lat && $p_lat<$max_lat){

                        //在范围内就跳跳过本层循环
                        break;
                    }else{
                                             
                        if($k == count($is_password['mesg'])-1){
                            break 2;
                        }else{
                            continue;
                        }
                    }
                }
            }
        }

        //生成经纬度的范围
        $ic_lang = $cre_obj->set_maxdegree($p_long,$p_lat);

        $ic_msg = array_merge($ic_checkmsg,$ic_lang);

        //把口令赋值到数组中
        $ic_msg['password'] = $name_password;

        //建立签到实列
        $name_id = $creM_obj->create($ic_msg);

        //检测是否创建成功
        if(is_numeric($name_id)){
            $r_msg['name_id'] = $name_id;
            $r_msg['password'] = $name_password;
            $r_msg['isok'] = true;
        }else{
            $r_msg['errmsg'] = '创建失败';
            $r_msg['isok'] = false;
        }

        $this->output($r_msg);

    }
}