<?php
namespace app\Models;

use fastFrame\base\Model;
use fastFrmae\db\Db;

/**
 * 获取信息的摸版
 */
class GetmessageModel extends Model {

    /**
     * 自定义当前模型操作的数据库表名称，
     * 如果不指定，默认为类名称的小写字符串，
     * 这里就是 item 表
     * @var string
     */
    protected $table = 'user_wechat';

    /**
     * 查找个人信息用户数据
     * @param $id
     * @return 查找出来的用户信息
     */
    public function slc_userMessage($id){
        $sw_user = array("*"=>$id);
        $user_message = $this->select_all($this->table,array('*'),$sw_user);
        return $user_message[0];
    }
}