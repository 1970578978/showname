<?php
namespace fastFrame\base;

/**
 * 控制器基类
 */
class Controller
{
    protected $_controller;
    protected $_action;
    protected $_view;

    // 构造函数，初始化属性，并实例化对应模型
    public function __construct($controller, $action)
    {
        $this->_controller = $controller;
        $this->_action = $action;
        
    }

    // 分配变量
    public function output($data)
    {
        header('Content-Type: application/json; charset=utf8'); 
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    // 渲染视图
    
}