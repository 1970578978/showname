<?php
/* $url = $_SERVER['REQUEST_URI'];
$position = strpos($url, '?');
$url = $position === false ? $url : substr($url, $position);
var_dump($position);
var_dump($url);
$url = trim($url, '?');

        if ($url) {
            // 使用“/”分割字符串，并保存在数组中
            $urlArray = explode('&', $url);
            // 删除空的数组元素
            $urlArray = array_filter($urlArray);
            
            //获取等号后面的1参数
            foreach($urlArray as $k=>$value){
                $position = strpos($value, '=');
                $urlArray[$k] = $position === false ? $value : substr($value, $position+1);
            }
            // 获取控制器名
            $controllerName = ucfirst($urlArray[0]);
            
            // 获取动作名
            array_shift($urlArray);
            $actionName = $urlArray ? $urlArray[0] : $actionName;
            
            // 获取URL参数
            array_shift($urlArray);
            $param = $urlArray ? $urlArray : array();
        }
        var_dump($controllerName);
        var_dump($actionName);
        var_dump($param); */

       
        $stime = strtotime("2018-5-1");
        $week2 = date("w",$stime);
        
        $monthd = date("t",$stime);

        date_default_timezone_set("PRC");
        $nowtime = date("Y.m.d",time());
        
        $dateArray = explode(".",$nowtime);
        $year = (int)$dateArray[0];
        $month = (int)$dateArray[1];
        $day = (int)$dateArray[2];
        var_dump(is_numeric($month));
        