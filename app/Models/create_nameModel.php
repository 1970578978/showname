<?php
namespace app\models;

use fastFrame\base\Model;
use fastFrmae\db\Db;

/**
 * 关于签到实列的操作
 * 创建一个发起签到实列
 */
class create_nameModel extends Model {

    /**
     * 自定义当前模型操作的数据库表名称，
     * 如果不指定，默认为类名称的小写字符串，
     * 这里就是 item 表
     * @var string
     */
    protected $table = 'create_name';


    /**
     * 创建一个签到实列，并插入到数据库中
     * 
     * @param 要插入的数据的数组形式
     * @return int 返回插入的状态和对应的id
     */
    public function create($nameMesg){
        $name_id = $this->insert($this->table,$nameMesg);

        return $name_id;

    }


    /**
     * 查找随机生成的签到口令是不是存在  
     * 
     * @param $paswd 检查的签到口令
     * @return boolean 是不是存在
     */
    public function check_paswd($paswd){
        $r_check = array();

        $sw_paswd = array("password"=>$paswd,"status"=>1);

        $is_name = $this->select_all($this->table,array("*"),$sw_paswd);

        if(empty($is_name)){

            $r_check['isok'] = true;
        }else{

            $r_check['isok'] = false;
            //可能存在多个
            $r_check['mesg'] = $is_name;
        }

        return $r_check;

    }
}