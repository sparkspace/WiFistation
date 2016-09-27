<?php
    include "php/database.php";
    $conn = connectDB();

//取之前1小时温度
$result_tem = @mysql_query('SELECT temperature FROM weatherdata ORDER BY did DESC LIMIT 0,7',$conn);
$result_tem_arr = array();   //存储数组
while($rows=mysql_fetch_array($result_tem)){      //$rows是数组
    settype($rows['temperature'],'float');          //string变成float
    $result_tem_arr[] =$rows['temperature'];        //提取赋值
}
    $result_tem_arr = reverse($result_tem_arr);
$json_tem = json_encode($result_tem_arr);       //转化为json格式

//取之前1小时湿度

$result_hum = @mysql_query('SELECT humidity FROM weatherdata ORDER BY did DESC LIMIT 0,7',$conn);

$result_hum_arr = array();   //存储数组
while($rows=mysql_fetch_array($result_hum)){      //$rows是数组
    settype($rows['humidity'],'float');          //string变成float
    $result_hum_arr[] =$rows['humidity'];        //提取赋值
}
    $result_hum_arr = reverse($result_hum_arr);
$json_hum = json_encode($result_hum_arr);       //转化为json格式


//取之前1小时光照

$result_ill = @mysql_query('SELECT lightness FROM weatherdata ORDER BY did DESC LIMIT 0,7',$conn);

$result_ill_arr = array();                           //存储数组
while($rows=mysql_fetch_array($result_ill)){         //$rows是数组
    settype($rows['illumination'],'float');          //string变成float
    $result_ill_arr[] =$rows['lightness'];        //提取赋值
}
    $result_ill_arr = reverse($result_ill_arr);
    $json_ill = json_encode($result_ill_arr);       //转化为json格式
    $status = weather();                        //更换背景图片
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>气象站</title>
    <script src="js/echarts.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body style="background-image: url('img/<?=$status?>.jpg')">
<div class="header" style="position:relative;text-align: center">
    <div class="history">
        <a href="history.php" target="frame" style="text-decoration: none">
            <span style="color:#f0fafa;font-size: 38px">历史1小时</span>
        </a>
    </div>
    <a href="history_8.php" target="frame" style="text-decoration: none">
        <span style="text-decoration: none;color:#f0fafa;font-size: 38px">历史8小时</span>
    </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

    <a href="history_24.php" target="frame" style="text-decoration: none">
        <span style="text-decoration: none;color:#f0fafa;font-size: 38px">历史24小时</span>
    </a>

</div>

<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
<div id="chart_tem" style="width: 100%;height:450px;margin: 0 auto">

</div>
<div id="chart_hum" style="width: 100%;height:450px;margin: 0 auto">
</div>
<div id="chart_light" style="width: 100%;height:450px;margin: 0 auto">
</div>
<script type="text/javascript">
    var myChart_tem = echarts.init(document.getElementById('chart_tem'));
    var myChart_hum = echarts.init(document.getElementById('chart_hum'));
    var myChart_light = echarts.init(document.getElementById('chart_light'));

    //温度图
    option_tem = {
        title: {
            text: '温度',
            textStyle:{        //标题文字格式
                fontSize: 38,
                fontWeight: 'bolder',
                color: 'white'
            }
        },
        grid:{
            show:true,
            y:'3%',

            borderWidth:0
            //backgroundColor:'rgba(255,255,255,0.15)'
        },
        tooltip: {                    //在移动过程中显示数据
            trigger: 'item'
        },
        legend: {               //图例
            show:false,
            data:['气温']
        },
        dataZoom:{
            show:false
      //      type:'inside'
        },
        toolbox: {
            show: false

        },
        xAxis:  {   //横坐标  时间,读取系统时间
            show:false,
            type: 'category',
            axisLabel:{      //坐标轴
                textStyle:{
                    color:'white'
                }
            },
            axisLine:{
                lineStyle:{
                    color:'white'
                }
            },
            boundaryGap: false,
            splitLine: {
                show: false
            },
            data:['1小时前','50分钟前','40分钟前','30分钟前','20分钟前','10分钟前','现在']
        },

        yAxis: {
            show:false,
            type: 'value',
            boundaryGap:true,
            scale: true,
            boundaryGap:[0.01,0.01],
            axisLabel: {
                formatter: '{value} °C'     //纵坐标
            },
            splitLine: {
                show: false
            }

        },
        series: [
            {
                name:'温度',
                type:'line',
                label:{
                    normal:{
                        textStyle:{
                            fontSize:28
                        }
                    }
                },
                formatter:'{line}°C',
                itemStyle : {
                    normal: {
                        label : {
                            show: true,     //每个点显示数据
                            position: 'top'
                        },
                        color : '#faf7f7'    //修改颜色
                    }
                },
                data:<?=$json_tem?>

            }
        ]
    };

    //湿度图
    option_hum = {
        title: {
            text: '湿度',
            textStyle:{        //标题文字格式
                fontSize: 38,
                fontWeight: 'bolder',
                color: 'white'
            }
        },
        tooltip: {                    //在移动过程中显示数据
            trigger: 'item'
        },
        grid:{
            show :true,
            y:'3%',
            //y2:'0.2%',
            borderWidth:0
            //backgroundColor:'rgba(255,255,255,0.15)'
        },
        legend: {               //图例
            data:['湿度'],
            show:false
        },
        dataZoom:{
            show:false
        //    type:'inside'
        },
        toolbox: {
            show: false,      //功能区
            feature: {
                dataZoom: {
                    yAxisIndex: 'none'
                },
                dataView: {readOnly: false},
                magicType: {type: ['line', 'bar']},
                restore: {},          //还原为折线图
                saveAsImage: {}      //保存为图片
            }
        },
        xAxis:  {   //横坐标  时间,读取系统时间
            show:false,
            type: 'category',
            axisLabel:{      //坐标轴
                textStyle:{
                    color:'white'
                }
            },
            axisLine:{
                lineStyle:{
                    color:'white'
                }
            },
            boundaryGap: false,
            splitLine: {
                show: false
            },
            data:['1小时前','50分钟前','40分钟前','30分钟前','20分钟前','10分钟前','现在']
        },
        yAxis: {
            show:false,
            type: 'value',
            boundaryGap:true,
            scale: true,
            boundaryGap:[0.01,0.01],
            axisLabel: {
                formatter: '{value} %'     //纵坐标
            },
            splitLine: {
                show: false
            }

        },
        series: [
            {
                name:'湿度',
                type:'line',
                label:{
                    normal:{
                        textStyle:{
                            fontSize:28
                        }
                    }
                },
                //formatter:'{line}°C',
                itemStyle : {
                    normal: {
                        label : {
                            show: true,     //每个点显示数据
                            position: 'top'
                        },
                        color : '#faf7f7'    //修改颜色
                    }
                },
                data:<?=$json_hum?>
            }
        ]
    };

    //光照图
    option_light = {
        title: {
            text: '光照',
            textStyle:{        //标题文字格式
                fontSize: 38,
                fontWeight: 'bolder',
                color: 'white'
            }
        },
        tooltip: {                    //在移动过程中显示数据
            trigger: 'item'
        },
        grid:{
            show :true,
            y:'3%',
            borderWidth:0
            //backgroundcolor:'rgba(255,255,255,0.15)'
        },
        legend: {                     //图例
            show:false,
            data:['亮度']
        },
        dataZoom:{
            show:false
            //type:'inside'
        },
        toolbox: {
            show: false,      //功能区
            feature: {
                dataZoom: {
                    yAxisIndex: 'none'
                },
                dataView: {readOnly: false},
                magicType: {type: ['line', 'bar']},
                restore: {},          //还原为折线图
                saveAsImage: {}      //保存为图片
            }
        },
        xAxis:  {   //横坐标  时间,读取系统时间
            show:true,
            type: 'category',
            axisLabel:{      //坐标轴
                textStyle:{
                    color:'white',
                    fontSize:24
                }
            },
            axisLine:{
                lineStyle:{
                    color:'white'
                }
            },
            boundaryGap: false,
            splitLine: {
                show: false
            },
            data:['1小时前','50分钟前','40分钟前','30分钟前','20分钟前','10分钟前','现在']
        },
        yAxis: {
            show:false,
            type: 'value',
            boundaryGap:true,
            scale: true,
            boundaryGap:[0.01,0.01],
            axisLabel: {
                formatter: '{value} °C'     //纵坐标
            },
            splitLine: {
                show: false
            }

        },
        series: [
            {
                name:'光照',
                type:'line',
                label:{
                    normal:{
                        textStyle:{
                            fontSize:28
                        }
                    }
                },
                data:<?=$json_ill?>,

                itemStyle : {
                    normal: {
                        label : {
                            show: true,     //每个点显示数据
                            position: 'top'
                        },
                        color : '#faf7f7',//修改颜色

                    }
                }
            }
        ]
    };

    myChart_tem.setOption(option_tem);   //绘图
    myChart_hum.setOption(option_hum);
    myChart_light.setOption(option_light);

    myChart_tem.group = 'group1';    //联动
    myChart_hum.group = 'group1';
    myChart_light.group = 'group1';
    echarts.connect('group1');

    window.onresize = function () {
        myChart_hum.resize();
        myChart_tem.resize();
        myChart_light.resize();
    }


</script>


</body>
</html>
