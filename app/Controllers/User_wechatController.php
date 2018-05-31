<?php
namespace app\Controllers;

use fastFrame\base\Controller;
use app\Models\User_wechatModel;
use usefunction\openidWay;

/**
 * 建立用户变的接口控制器
 * 包含用openid创建方法用户方法 in_openid
 * 
 * @method in_openid类似于注册的接口
 */
class User_wechatController extends Controller {

    /**
     * 获取openid插入数据并返回状态信息的方法
     * 
     * @param $code 微信登录后返回的码
     * @return openid 用户主键id 以及状态信息吗
     */
    public function in_openid($code){
        $r_data = array();

        if($code){
            
            if(empty($_POST['avatar'])){
                $r_data['id'] = null;
                $r_data['errMsg'] = '请输入头像链接参数';
                $r_data['isok'] = false;

                $this->output($r_data);
                die;
            }

            $openidMessage = (new openidWay)->getopenid($code);

            //判断是否获取了正确格式的openID数据
            if(array_key_exists('openid',$openidMessage)){
                //把头像写入数组
                $openidMessage['avatar'] = $_POST['avatar'];

                //格式正确就插入到数据库中
                $openid_id = (new user_wechatModel)->in_user($openidMessage);

                //判断是不是正确插入到数据库中
                if(is_numeric($openid_id)){

                    $r_data['id'] = $openid_id;
                    $r_data['openid'] = $openidMessage['openid'];
                    $r_data['isok'] = true;

                }else{
                    $r_data['id'] = null;
                    $r_data['errMsg'] = '数据插入错误';
                    $r_data['isok'] = false;
                }


            }else{
                //获取失败就返回失败及其原因
                $r_data['id'] = null;
                $r_data['errMsg'] = $openidMessage['errmsg'];
                $r_data['isok'] = false;
            }
        }else{
            //提示要输入参数
            $r_data['id'] = null;
            $r_data['errMsg'] = '请输入参数';
            $r_data['isok'] = false;
        }

        $this->output($r_data);
    }



    /**
     * 插入吐槽和联系方式
     * 
     * @param $id
     * @return 一些错误或者其他什么信息
     */
    public function in_spit($id){
        //检查参数
        $cre_obj = new openidWay;
        $creM_obj = new User_wechatModel;

        $c_checkmsg = $cre_obj->checkuid($id);
        $this->check_err($c_checkmsg);

        if(empty($_POST['feedBack'])){
            $r_data['errMsg'] = '请输各种像链接参数';
            $r_data['isok'] = false;

            $this->output($r_data);
            die;
        }else{

            $json_aray = json_decode($_POST['feedBack']);
            var_dump($json_aray);            
            $spitid = $creM_obj->in_spit($id,$json_aray['TUOCAO'],$json_aray['LIANXI']);

            if(is_numeric($spitid)){
                $r_msg['isok'] = true;
            }else{
                $r_msg['errMsg'] = '服务器出错';
                $r_msg['isok'] = false;
            }

            $this->output($r_msg);
        }
        
    }
}
