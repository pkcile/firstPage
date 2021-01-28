<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <title>3S集成</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <!-- page-css -->
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/map.css">
    <!-- font-icon -->
    <link rel="stylesheet" href="./css/font/iconfont.css">
    <style>
        body,
        html,
        div,
        li,
        h1,
        h2,
        h3 {
            margin: 0;
            padding: 0;
        }

        body,
        html {
            overflow: hidden;
            width: 100%;
            height: 100%;
            margin: 0;
            font-family: "微软雅黑";
        }

        #container {
            width: 100%;
            height: 93%;
        }

        /* 显示按钮样式 */
        ul li,
        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        /* 导航 */
        .map-wrap {
            width: 100%;
            position: absolute;
            top: 0px;
            border-radius: 5px;
            background-color: rgba(80, 175, 238, 0.9);
            box-shadow: 0 2px 8px 0 rgba(247, 222, 195, 0.9);
            z-index: 999;
            padding: .1em 0 .1em 0;
            -moz-user-select: none;
            -webkit-user-select: none;
            user-select: none;
        }

        /* 导航栏 */
        .map-keywoards {
            text-align: center;
            color: white;
            font-size: 1.1em;
        }

        .map-keywoards li {
            display: inline-block;
            width: 12em;
            line-height: 2.4em;
            border-bottom: .1em dotted white;
            margin: 0 1em 0 1em;
            cursor: pointer;
        }

        .map-keywoards li:hover {
            text-decoration: underline 3px solid red;
            color: black;
        }

        /* 图层管理工具 */
        .map-tools {
            position: relative;
        }

        .map-tool-infor {
            position: absolute;
            top: 0;
            right: 0;
        }

        .map-tool-infor li {
            padding: .5em 1em .5em 1em;
            cursor: pointer;
        }

        .map-tool-icon {
            font-size: 1.5em;
        }

        .map-tool-icon:hover {
            color: rgb(230, 81, 230);
            font-weight: 900;
        }

        /* 地点描述 */
        #descript_position {
            overflow: hidden;
            height: 0%;
            width: 100%;
            background-color: #FAFAFA;
            background-color: #bfa;
        }

        /* 卡片 */

        .descript_position_card {
            height: 200px;
            width: 85%;
            margin: 10px auto;
            background-color: #bfa;
            overflow-y: scroll;
            line-height: 1.2em;
            letter-spacing: .05em;
        }

        .descript_position_card>h1 {
            font-size: 1.1em;
            font-weight: bold;
            color: #1AA2FA;
        }

        .descript_position_card>.paragraph {
            font-size: .8em;
            font-weight: 500em;
        }

        .descript_position_card>h1,
        .descript_position_card>.paragraph {
            margin: 10px;
        }

        /* scroll */
        .descript_position_card::-webkit-scrollbar {
            width: 7px;
            height: 15px;

            background-color: rgb(216, 212, 212);
        }
        .descript_position_card::-webkit-scrollbar-track {
            border-radius: 10px;
            background-color: rgb(216, 212, 212);

        }
        .descript_position_card::-webkit-scrollbar-thumb  {
            border-radius: 10px;
            background-color: #60B6EF;
        }
    

        /* 地点汇总*/
        #sum_position {
            height: 7%;
            width: 100%;
            text-align: center;
            cursor: pointer;
            background-color: #f7dec3;
            /* background-color: rgba(80, 175, 238, 0.9); */
            letter-spacing: .1em;
        }

        #sum_position_center {
            text-align: center;
            line-height: 3.2em;
        }

        #sum_position_center_words:hover {
            color: #009F72;
            cursor: url(./img/user/cur888.png) 4 12, auto;
        }
    </style>
    <!-- jQuery -->
    <script type="text/javascript" src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    <!-- baidu -->
    <script type="text/javascript" src="https://api.map.baidu.com/api?v=2.0&ak=4ZdIV1KFQG8EqpNgn0c2OYdrVIGQnMTH">
    </script>
    <script type="text/javascript"
        src="https://api.map.baidu.com/api?type=webgl&v=1.0&ak=4ZdIV1KFQG8EqpNgn0c2OYdrVIGQnMTH"></script>
    <!-- main -->
    <script type="text/javascript" src="./js/map.js"></script>
</head>

<body>
    <ul class="map-wrap">

        <ul class="map-keywoards">
            <li class="point_story btn mobilehide" onclick="guideFood()">饮食</li>
            <li class="line_story btn mobilehide" onclick="test01()">休闲</li>
            <li class="line_story btn" onclick="test01()">地名</li>
            <li class="line_story btn" onclick="showPositionLine()">行程</li>
            <li class="line_story btn" onclick="toolOpenClose()">图层</li>
            <li class="line_story btn" onclick="test()">工具</li>

        </ul>
        <ul class="map-tools">
            <ul class="map-tool-infor" id="map-tool-infor" style="display: none;">
                <li onclick="showPositionYourself()">
                    <span title="位置显示" class="iconfont map-tool-icon">&#xf005a;</span>
                </li>
                <li onclick="showText()">
                    <span title="文字显示" class="iconfont map-tool-icon">&#xe67f;</span>
                </li>
                <li onclick="showIcon()">
                    <span title="图标显示" class="iconfont map-tool-icon">&#xe613;</span>
                </li>
                <li onclick="map_left()">
                    <span title="向左旋转" class="iconfont map-tool-icon">&#xe727;</span>
                </li>
                <li onclick="map_right()">
                    <span title="向右旋转" class="iconfont map-tool-icon">&#xe728;</span>
                </li>
            </ul>
        </ul>
    </ul>

    <div id="container">
    </div>
    <div id="descript_position">
        <!-- 测试中，待处理…… -->
        <div class="descript_position_center">
            <div class="descript_position_card">
                <h1>标题测试</h1>
                <div class="paragraph">
                    《失控》，全名为《失控：机器、社会与经济的新生物学》（Out of Control: The New Biology of Machines, Social Systems, and the
                    Economic World）。
                    每次抱起这本大部头时，我都会产生“我这是在搞科研嘛”“我好牛逼啊居然看这玩意哈哈哈”“我擦这是什么啊我真是弱爆了”的错觉。
                </div>
                <div class="paragraph">
                    《失控》，全名为《失控：机器、社会与经济的新生物学》（Out of Control: The New Biology of Machines, Social Systems, and the
                    Economic World）。
                    每次抱起这本大部头时，我都会产生“我这是在搞科研嘛”“我好牛逼啊居然看这玩意哈哈哈”“我擦这是什么啊我真是弱爆了”的错觉。
                </div>
                <div class="paragraph">
                    《失控》，全名为《失控：机器、社会与经济的新生物学》（Out of Control: The New Biology of Machines, Social Systems, and the
                    Economic World）。
                    每次抱起这本大部头时，我都会产生“我这是在搞科研嘛”“我好牛逼啊居然看这玩意哈哈哈”“我擦这是什么啊我真是弱爆了”的错觉。
                </div>
                <div class="paragraph">
                    《失控》，全名为《失控：机器、社会与经济的新生物学》（Out of Control: The New Biology of Machines, Social Systems, and the
                    Economic World）。
                    每次抱起这本大部头时，我都会产生“我这是在搞科研嘛”“我好牛逼啊居然看这玩意哈哈哈”“我擦这是什么啊我真是弱爆了”的错觉。
                </div>
                <div class="paragraph">
                    《失控》，全名为《失控：机器、社会与经济的新生物学》（Out of Control: The New Biology of Machines, Social Systems, and the
                    Economic World）。
                    每次抱起这本大部头时，我都会产生“我这是在搞科研嘛”“我好牛逼啊居然看这玩意哈哈哈”“我擦这是什么啊我真是弱爆了”的错觉。
                </div>
                <div class="shudong" style="width: 100%; height: 100px; background-color: #009F72;">
                    <input type="text">你的名字
                    <input type="text">你的年龄
                </div>
            </div>
        </div>

    </div>
    <div id="sum_position" onclick="show_descript_position()">
        <div id="sum_position_center" onclick="">
            <span id="sum_position_center_words" onclick="test()">共有0个线索</span>
        </div>
    </div>
    <script>
        //饮食测试
        var marker_test = [];
        var marker_click_infor = [];
        //点对应的图标参数
        var myIcon = [];
        //数组存储json数据,obj_test数组存放所有食堂相关的点位
        var obj_test = [];
        //读入位置点
        $.getJSON("./json/position_true.json", function (data) {
            for (var i = 0; i < data.line.length; i++) {
                obj_test[i] = data.line[i];
            }
            console.log(obj_test);
        });

        function guideFood() {
            //1.地图移动位置        
            map.centerAndZoom(new BMapGL.Point(obj_test[0].location[0], obj_test[0].location[1]), 19);
            //2.添加坐标点位图像、及信息
            for (var i = 0; i < obj_test.length; i++) {
                //点位置显示
                myIcon[i] = new BMapGL.Icon(obj_test[i].icon, new BMapGL.Size(32, 32));
                marker_test[i] = new BMapGL.Marker(new BMapGL.Point(obj_test[i].location[0], obj_test[i].location[1]), {
                    icon: myIcon[i],
                });
                map.addOverlay(marker_test[i]);
                // 点点击事件
                marker_click(marker_test[i], obj_test[i]);
            }
        }
        //添加点击事件
        function marker_click(marker, content) {
            marker.addEventListener('click', function () {
                openInfoImage(marker, content);
            })
        }
        //图片框显示
        function openInfoImage(marker, content) {
            // 创建图文信息窗口
            var sContent = `
                <div>
                    <h4 style='margin:0 0 5px 0; padding-left: 15px;'>` +
                content.content_infor.h4 +
                `</h4>
                    <img style='float:right;margin:0 4px 22px' id='imgDemo' src='` +
                content.content_infor.img_src +
                `' width='139' height='104'/>` +

                `<p style='margin:0;line-height:1.5em;font-size:13px;text-indent:2em; width: 400px'>` +
                content.content_infor.paragraph[0] +
                `</p>` +
                `<p style="text-align: right; padding-right: 160px;">` +
                content.content_infor.date +
                `</p>` +
                `</div>
                `;

            var infoWindow = new BMapGL.InfoWindow(sContent);
            console.log(infoWindow.content);
            console.log(infoWindow);

            // marker添加点击事件
            marker.openInfoWindow(infoWindow);
            // 图片加载完毕重绘infoWindow
            document.getElementById('imgDemo').onload = function () {
                infoWindow.redraw(); // 防止在网速较慢时生成的信息框高度比图片总高度小，导致图片部分被隐藏
            };
        }

        //测试功能
        function test01() {
            alert("待测试");
            // //1.地图移动位置        
            // map.centerAndZoom(new BMapGL.Point(obj_test[0].location[0], obj_test[0].location[1]), 19);
            // //2.显示
            // for (var i = 0; i < obj_test.length; i++) {
            //     var contents = obj_test[i];
            //     //位置显示
            //     var marker = new BMapGL.Marker(new BMapGL.Point(obj_test[i].location[0], obj_test[i].location[1]));
            //     map.addOverlay(marker);
            //     //标签显示
            //     var label = new BMapGL.Label(contents.infor, {
            //         offset: new window.BMapGL.Size(10, -24)
            //     });
            //     label.enableMassClear = true;
            //     label.setStyle({
            //         borderRadius: '10px',
            //         borderColor: '#ababab',
            //         padding: '3px 20px',
            //         fontSize: '12px',
            //         color: '#757676'
            //     });
            //     marker.setLabel(label);
            //     //添加标签点击事件
            //     addClickHandler(contents, marker);
            // }
        }
        //标记点点击后的事件
        function addClickHandler(contents, marker) {
            marker.addEventListener("click", function (e) {
                openInfo(contents, e)
            });
        }
        //弹窗事件
        function openInfo(contents, e) {
            var p = e.target;
            var point = new BMapGL.Point(p.getPosition().lng, p.getPosition().lat);
            console.log("contents" + contents.infor);
            var message = "地址：" + contents.infor;
            var opts = {
                title: contents.title
            }
            var infoWindow = new BMapGL.InfoWindow(message, opts); // 创建信息窗口对象
            map.openInfoWindow(infoWindow, point); //开启信息窗口
        }

        //视图位置移动
        function map_left() {
            map_left_right += 10;
            map.setHeading(map_left_right);
        }

        function map_right() {
            map_left_right -= 10;
            map.setHeading(map_left_right);
        }

        function map_up() {
            map_down_up += 10;
            map.setTilt(map_down_up);
        }

        function map_down() {
            map_down_up -= 10;
            map.setTilt(map_down_up);
        }
    </script>
    <!-- 页面显示 -->
    <script>
        var i = 5;

        function show_descript_position() {
            // 地图
            var center_container = document.getElementById("container");
            // 内容介绍
            var descript_position = document.getElementById("descript_position");
            //总结
            var sum_position = document.getElementById("sum_position");
            if (descript_position.style.height == "0%") {
                // descript_position.style.display = "block";
                descript_position.style.height = "30%";
                center_container.style.height = "63%";
            } else {
                center_container.style.height = "93%";
                descript_position.style.height = "0%";
            }

        }

        function test(e) {
            // 如何消除事件传递
            // alert(9999);
            stop_event_fun(e);
        }

        function stop_event_fun(e) {
            if (e && e.stopPropagation) {
                //即为非IE浏览器
                e.stopPropagation();
            } else {
                //IE方式取消事件冒泡    
                window.event.cancelBubble = true;
            }
        }
    </script>
    <!-- 访问统计 -->
    <script>
        var _hmt = _hmt || [];
        (function () {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?aecc3f51d34ef8f846d5633c43d7988c";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>
</body>
<!-- phone/windows apart -->
<script type="text/javascript" src="./js/phoneIdenty.js"></script>

</html>