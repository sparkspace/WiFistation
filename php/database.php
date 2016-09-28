<?php

    function connectDB(){
    if (!$conn) {
        die("failed");
    }
    @mysql_query("SET NAMES UTF8");
    @mysql_select_db('wifistation', $conn) or die("connot find");
    return $conn;
    }

    function average($query_result,$period,$type){

        $result_arr = array();
        $average =array();
        $sum = 0;
        while($rows=mysql_fetch_array($query_result)){      //$rows是数组
            settype($rows[$type],'float');
            $result_arr[] =$rows[$type];
        }
        $result_arr = reverse($result_arr);
        for($j=0;$j<=$period;$j++) {
            for ($i = 6*$j; $i <=5+6*$j ; $i++) {    //后期要改成6
                $sum += $result_arr[$i];
            }
            $average[$j] = round($sum/6,2);        //改6
            $sum =0;
        }
        $json = json_encode($average);
        return $json;
    }
    function reverse($array){
        $size = count($array);

        for($i=0;$i<=floor($size/2);$i++){
            $b = $array[$size-$i-1];
            $array[$size-$i-1] = $array[$i];
            $array[$i] = $b;
        }
        return $array;

    }
    function weather(){
        $url = 'http://api.map.baidu.com/telematics/v3/weather?location=beijing&output=json&ak=AeRn2QES27pNjgo0DGzG048XZaEz6uyw';
        $html = file_get_contents($url);
        $weather_array = json_decode($html,true);
        $weather_info =  $weather_array['results'][0]['weather_data'][0]['weather'];
        if(strstr($weather_info,"晴")){
            return 'sun';
        }
        elseif(strstr($weather_info,'云')){
            return 'cloudy';
        }
        elseif(strstr($weather_info, "雨")){
            return 'rain';
        }
        elseif(strstr($weather_info, "雪")){
            return 'snow';
        }
        else{
            return 'default';
        }
    }
    function words(){
        $cloudy= array('南风暖, 北风寒, 东风潮湿, 西风干',
                       '雨前濛濛无大雨, 雨后濛濛雨不停',
                       '风大夜无露, 阴天夜无霜',
                       '低云不见走, 落雨在不久');
        $sun = array('朝霞不出门, 晚霞行千里',
                     '云吃火有雨, 火吃云晴天',
                     '朝起红霞晚落雨, 晚起红霞晒死鱼',
                     '黄昏天发红, 渔翁笑声隆');
        $rain = array('燕子低飞, 天将雨',
                      '蚯蚓路上爬, 雨水乱如麻',
                      '朝有棉絮云, 下雨雷雨鸣',
                      '一场秋雨一场寒, 十场秋雨穿上棉');
        $snow = array('冬天麦盖三层被, 来年枕着馒头睡',
                      '霜重见晴天, 雪多兆丰年',
                      '冬雪回暖迟, 春雪回暖早',
                      '腊雪是宝, 春雪不好');
        $weather_info = weather();
        if($weather_info=="sun"){
            $random_key = array_rand($sun);
            return $sun[$random_key];
        }
        elseif($weather_info=='cloudy'){
            $random_key = array_rand($cloudy);
            return $cloudy[$random_key];
        }
        elseif($weather_info=='rain'){
            $random_key = array_rand($rain);
            return $rain[$random_key];
        }
        elseif($weather_info=='snow'){
            $random_key = array_rand($snow);
            return $snow[$random_key];
        }
        else{
            return "先雷后雨雨必小，先雨后雷雨必大。";
        }

    }


?>



