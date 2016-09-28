# WiFistation
WiFi气象站项目，实现了天气的实时和历史1小时、8小时、24小时数据的显示<br>
下一步的目标：<br>
1、用nodeJS+Express改善服务器服务质量<br>
2、运用各种web框架完善界面的显示<br>

硬件端代码为cookieWeatherStationThingworx.ino <br><br>
服务器端代码为其他所有文件<br>
其组织结构为：
CSS文件为样式表文件<br>
img文件存放背景图片<br>
js文件存放echarts的库<br>
php文件中为数据处理的函数<br>
index.php为主页<br>
history等php文件为历史数据展示页面<br>
get_data.php负责接收传递过来的传感器数据<br>
