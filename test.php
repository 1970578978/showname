<?php

        /* $stime = strtotime("2018-5-1");
        $week2 = date("w",$stime);
        
        $monthd = date("t",$stime);

        date_default_timezone_set("PRC");
        $nowtime = date("Y.m.d",time());
        
        $dateArray = explode(".",$nowtime);
        $year = (int)$dateArray[0];
        $month = (int)$dateArray[1];
        $day = (int)$dateArray[2];
        var_dump(is_numeric($month)); */
        


         $path = 'excel/test.xlsx';
         /*
$file = fopen($path, 'r');
//标题行读取（第一行）
$row = fgets($file); */
$row = file_get_contents($path);

define('UTF32_BIG_ENDIAN_BOM', chr(0x00) . chr(0x00) . chr(0xFE) . chr(0xFF));  
                        define('UTF32_LITTLE_ENDIAN_BOM', chr(0xFF) . chr(0xFE) . chr(0x00) . chr(0x00));  
                        define('UTF16_BIG_ENDIAN_BOM', chr(0xFE) . chr(0xFF));  
                        define('UTF16_LITTLE_ENDIAN_BOM', chr(0xFF) . chr(0xFE));  
                        define('UTF8_BOM', chr(0xEF) . chr(0xBB) . chr(0xBF));  
                        $first2 = substr($row, 0, 2);  
                        $first3 = substr($row, 0, 3);  
                        $first4 = substr($row, 0, 3);  
                        $encodType = "";  
                        if ($first3 == UTF8_BOM)  
                            $encodType = 'UTF-8 BOM';  
                        else if ($first4 == UTF32_BIG_ENDIAN_BOM)  
                            $encodType = 'UTF-32BE';  
                        else if ($first4 == UTF32_LITTLE_ENDIAN_BOM)  
                            $encodType = 'UTF-32LE';  
                        else if ($first2 == UTF16_BIG_ENDIAN_BOM)  
                            $encodType = 'UTF-16BE';  
                        else if ($first2 == UTF16_LITTLE_ENDIAN_BOM)  
                            $encodType = 'UTF-16LE';  
  
                        //下面的判断主要还是判断ANSI编码的·  
                        if ($encodType == '') {//即默认创建的txt文本-ANSI编码的  
                            $content = iconv("GBK", "UTF-8//IGNORE", $row);  
                        } else if ($encodType == 'UTF-8 BOM') {//本来就是UTF-8不用转换  
                            $content = $row;  
                        } else {//其他的格式都转化为UTF-8就可以了  
                            $content = iconv($encodType, "UTF-8", $row);  
                        }  

var_dump($row);die;


$row = explode("\t", $row);
$title = array();
foreach($row as $k => $v) {
    $title[$k] = str_replace("\n", '', $v);
}
//内容读取
var_dump($title);
$data = array();
$count = 0;
while(!feof($file)) {
    $row = fgets($file);
    $row = explode("\t", $row);
    if(!$row[0]) continue;//去除最后一行
    foreach($title as $k => $v) {
        $data[$count][$title[$k]] = $row[$k];
    }
    $count ++;
}
fclose($file);
echo '<pre>';
print_r($data);

"SELECT * from create_name where DATE_SUB(now(), INTERVAL 1 DAY) >= createtime";
"UPDATE create_name set status = 0 where DATE_SUB(now(), INTERVAL 1 DAY) >= createtime";