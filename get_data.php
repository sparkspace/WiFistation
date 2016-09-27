<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

<?php
$temperature = $_GET["temperature"];
$humidity = $_GET["humidity"];
$lightness = $_GET["lightness"];
echo $temperature;
    $conn = @mysql_connect('115.28.144.64', 'root', 'lh920225');
    if (!$conn) {
        die("failed");
    }
    @mysql_query("SET NAMES UTF8");
    @mysql_select_db('wifistation', $conn) or die("connot find");
if(empty($temperature)||empty($humidity)||empty($lightness)){
    $result = @mysql_query('SELECT * FROM weatherdata ORDER BY did DESC LIMIT 0,1',$conn);
    $result_arr = @mysql_fetch_assoc($result);
    $temperature_new = $result_arr['temperature'];
    $humidity_new = $result_arr['humidity'];
    $lightness_new = $result_arr['lightness'];
    echo $temperature_new."ÎÂ¶È";
    $insert ="insert into  weatherdata values('','1','$temperature_new','$humidity_new','$lightness_new')";
}
else{
    $insert = "insert into  weatherdata values('','1','$temperature','$humidity','$lightness')";
}


@mysql_query($insert,$conn);

?>
</body>
</html>