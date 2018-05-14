<?php
namespace fastFrame\base;

use fastFrame\db\Sql;
use fastFrame\db\Db;

class Model extends Sql
{
    protected $model;
    

    public function __construct()
    {
        $this->pdoObject = (new DB)->__set();
        // 获取数据库表名
        if (!$this->table) {

            // 获取模型类名称
            $this->model = get_class($this);

            // 删除类名最后的 Model 字符
            $this->model = substr($this->model, 0, -5);

            // 数据库表名与类名一致
            $this->table = strtolower($this->model);
        }
    }
}