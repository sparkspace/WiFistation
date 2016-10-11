<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<!--以下为接收数据代码-->
<?php
$temperature = $_GET["temperature"];
$humidity = $_GET["humidity"];
$lightness = $_GET["lightness"];
    $conn = @mysql_connect('host_address', 'host_name', 'host_password');   //链接服务器
    if (!$conn) {
        die("failed");
    }
    @mysql_query("SET NAMES UTF8");
    @mysql_select_db('wifistation', $conn) or die("connot find");             //选择数据库
if(empty($temperature)||empty($humidity)||empty($lightness)){                  //如果数据为空则重复插入上一条数据
    $result = @mysql_query('SELECT * FROM weatherdata ORDER BY did DESC LIMIT 0,1',$conn); //SELECT为SQL语句，result为查询结果返回
    $result_arr = @mysql_fetch_assoc($result);                                 //转化成为数组
    $temperature_new = $result_arr['temperature'];
    $humidity_new = $result_arr['humidity'];
    $lightness_new = $result_arr['lightness'];
    $insert ="insert into  weatherdata values('','1','$temperature_new','$humidity_new','$lightness_new')";   //SQL插入语句
}
else{                                                                         //如果接收到数据则插入数据表中
    $insert = "insert into  weatherdata values('','1','$temperature','$humidity','$lightness')";
}
@mysql_query($insert,$conn);                                                   //执行插入语句
?>
</body>
</html>
