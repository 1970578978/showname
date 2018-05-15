<?php
namespace app\controllers;

use fastFrame\base\Controller;
use app\models\ItemModel;
 
class ItemController extends Controller
{
    // 首页方法，测试框架自定义DB查询
    public function index()
    {
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

        if ($keyword) {
            $items = (new ItemModel())->search();
        } else {
            // 查询所有内容，并按倒序排列输出
            // where()方法可不传入参数，或者省略
            
            $items = (new ItemModel)->search();
            
        }

        $this->output($items);
        
    }

    
}