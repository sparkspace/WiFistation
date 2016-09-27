<?php
include "php/database.php";
$conn = connectDB();

$result_tem = @mysql_query('SELECT temperature FROM weatherdata ORDER BY did DESC LIMIT 0,150',$conn);
$json_tem = average($result_tem,24,'temperature');

$result_hum = @mysql_query('SELECT humidity FROM weatherdata ORDER BY did DESC LIMIT 0,150',$conn);
$json_hum = average($result_hum,24,'humidity');

$result_ill = @mysql_query('SELECT lightness FROM weatherdata ORDER BY did DESC LIMIT 0,150',$conn);
$json_ill = average($result_ill,24,'lightness');
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

    <a href="history.php" target="frame" style="text-decoration: none">
        <span style="color:#f0fafa;font-size: 38px">历史1小时</span>
    </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

    <a href="history_8.php" target="frame" style="text-decoration: none">
        <span style="text-decoration: none;color:#f0fafa;font-size: 38px">历史8小时</span>
    </a>
<div class="history">
    <a href="history_24.php" target="frame" style="text-decoration: none">
        <span style="text-decoration: none;color:#f0fafa;font-size: 38px">历史24小时</span>
    </a>
</div>


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
            trigger: 'axis'
        },
        legend: {               //图例
            show:false,
            data:['气温']
        },
        dataZoom:{
            type: 'inside',
            show: false,
            start:75,
            end: 100,
            zoomLock:true
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
            data:['24小时前','23小时前','22小时前','21小时前','20小时前','19小时前','18小时前','17小时前','16小时前','15小时前','14小时前','13小时前','12小时前','11小时前','10小时前','9小时前','8小时前','7小时前','6小时前','5小时前','4小时前','3小时前','2小时前','1小时前','现在']
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
            type: 'inside',
            show: false,
            start: 25,
            end: 100,
            zoomLock:true
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
            data:['24小时前','23小时前','22小时前','21小时前','20小时前','19小时前','18小时前','17小时前','16小时前','15小时前','14小时前','13小时前','12小时前','11小时前','10小时前','9小时前','8小时前','7小时前','6小时前','5小时前','4小时前','3小时前','2小时前','1小时前','现在']
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
                data: <?=$json_hum?>

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
            //backgroundColor:'rgba(255,255,255,0.15)'
        },
        legend: {                     //图例
            show:false,
            data:['亮度']
        },
        dataZoom:{
            type: 'inside',
            show: true,
            start: 25,
            end: 100,
            zoomLock:true
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
            data:['24小时前','23小时前','22小时前','21小时前','20小时前','19小时前','18小时前','17小时前','16小时前','15小时前','14小时前','13小时前','12小时前','11小时前','10小时前','9小时前','8小时前','7小时前','6小时前','5小时前','4小时前','3小时前','2小时前','1小时前','现在']
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
                        color : '#faf7f7'    //修改颜色
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
