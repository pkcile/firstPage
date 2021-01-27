 //位置信息
 var ggPoint;
 var map;
 //视角
 var map_down_up = 0;
 var map_left_right = 0;
 //餐厅点坐标
 var marker_canteen = [];
 //位置图标、位置标注
 var current_marker;
 var current_label;
 var false_marker;
 var false_label;
 var circle_current_marker;
 //poi文字、poi图标
 var iii01 = [0, 0, 0, 0, 0, 0, 0];
 var polylinePointsArray = [];
 var polyline2;


 function loadJScript() {
     var script = document.createElement('script');
     script.type = 'text/javascript';
     script.src = 'https://api.map.baidu.com/api?type=webgl&v=1.0&ak=4ZdIV1KFQG8EqpNgn0c2OYdrVIGQnMTH&callback=init';
     document.body.appendChild(script);
 }
 window.onload = loadJScript; // 异步加载地图
 function init() {
     try{
        var static_point = new BMapGL.Point(116.038525, 28.68618);
        map = new BMapGL.Map('container'); // 创建Map实例
        map.enableScrollWheelZoom(true);// 启用滚轮放大缩小
        map.centerAndZoom(static_point, 16);
        map.setHeading(map_left_right);
        map.setTilt(map_down_up);
        // 创建折线
        polyline = new BMapGL.Polyline([
            new BMapGL.Point(116.041137, 28.683057),
            new BMapGL.Point(116.036857, 28.68924),
            new BMapGL.Point(116.037881, 28.690136),
            new BMapGL.Point(116.032747, 28.687644)
            //  116.041137,28.683057 方荫楼
            //  116.036857,28.68924 五食堂
            //  116.037881,28.690136 一食堂
            //  116.032747,28.687644 三食堂  
            //  116.032548,28.688138  三栋饭卡充值办理，问题解决
            //  学生会在哪里
            //  学校建行
        ], {
            strokeColor: 'blue',
            strokeWeight: 2,
            strokeOpacity: 0.5
        });
        // 批量绑定事件
        var clickEvts = ['click', 'dblclick', 'rightclick'];
        var moveEvts = ['mouseover', 'mouseout'];
        var overlays = [polyline];
   
        for (var i = 0; i < clickEvts.length; i++) {
            const event = clickEvts[i];
            for (var j = 0; j < overlays.length; j++) {
                const overlay = overlays[j];
                overlay.addEventListener(event, e => {
                    switch (event) {
                        case 'click':
                            var res = overlay.toString() + '被单击!';
                            break;
                        case 'dbclick':
                            var res = overlay.toString() + '被双击!';
                            break;
                        case 'rightclick':
                            var res = overlay.toString() + '被右击!';
                    }
                    alert(res);
                });
            }
        }
        for (var i = 0; i < moveEvts.length; i++) {
            const event = moveEvts[i];
            for (var j = 1; j < overlays.length; j++) {
                const overlay = overlays[j];
                overlay.addEventListener(event, e => {
                    switch (event) {
                        case 'mouseover':
                            overlay.setFillColor('#6f6cd8')
                            break;
                        case 'mouseout':
                            overlay.setFillColor('#fff');
                            break;
                    }
                });
            }
        }
        //添加比例尺
        var scaleCtrl = new BMapGL.ScaleControl();
        map.addControl(scaleCtrl);
        var zoomCtrl = new BMapGL.ZoomControl();
        map.addControl(zoomCtrl);
        // 添加3D控件
       //  var navi3DCtrl = new BMapGL.NavigationControl3D();
       //  map.addControl(navi3DCtrl);
        //设置地图显示元素
        map.setDisplayOptions({
            poi: true //是否显示POI信息 
        })
        //自定义样式
        // map.setMapStyleV2({styleJson:styleJson});
        //添加右键功能
        var menu = new BMapGL.ContextMenu();
        var txtMenuItem = [{
                text: '放大一级',
                callback: function () {
                    map.zoomIn();
                }
            },
            {
                text: '缩小一级',
                callback: function () {
                    map.zoomOut();
                }
            }
        ];
        for (var i = 0; i < txtMenuItem.length; i++) {
            menu.addItem(new BMapGL.MenuItem(txtMenuItem[i].text, txtMenuItem[i].callback, 100));
        }
        map.addContextMenu(menu);
        //显示icon、文字
        showIcon();
        showText();
        //镂空图形
        var bd = new BMapGL.Boundary();
        bd.get('南昌市', function (rs) {
            var hole = new BMapGL.Polygon(rs.boundaries, {
                fillColor: 'red',
                fillOpacity: 0.0
            });
            map.addOverlay(hole);
        });
   
        //获取定位
        navigator.geolocation.getCurrentPosition(function (position) {
            // 坐标转换
            ggPoint = new BMapGL.Point(position.coords.longitude, position.coords.latitude);
            // map.centerAndZoom(ggPoint, 16);
   
            // 标注
            false_marker = new BMapGL.Marker(ggPoint);
            map.addOverlay(false_marker);
            false_label = new BMapGL.Label("转换后的百度坐标（不正确）", {
                offset: new BMapGL.Size(20, -10)
            });
            false_marker.setLabel(false_label); //添加百度label
            map.removeOverlay(false_label);
            // 坐标转换并显示
            convertor();
        });
   
        $.getJSON("./json/position_line.json", function (data) {
           for (i = 0; i < data.line.length; i++) {
               polylinePointsArray[i] = new BMapGL.Point(data.line[i][0], data.line[i][1]);
           }
           polyline2 = new BMapGL.Polyline(polylinePointsArray, {
               strokeColor: 'blue',
               strokeWeight: 2,
               strokeOpacity: 0.5
           });     
       });
         
     }
     catch (e){
        alert("请通过本地服务器或远程服务器打开");
     }
 }


 // 坐标转换
 function convertor() {

     var convertor = new BMap.Convertor();
     var pointArr = [];
     pointArr.push(ggPoint);
     convertor.translate(pointArr, 1, 5, translateCallback);
 }
 translateCallback = function (data) {
     if (data.status === 0) { 
         // 创建小车图标
         var myIcon = new BMapGL.Icon("./img/1.svg", new BMapGL.Size(32, 32));
         current_marker = new BMapGL.Marker(data.points[0], {
             icon: myIcon,
            //  可拖拽
            //  enableDragging: true,
         });
         ggPoint = data.points[0];
         map.addOverlay(current_marker);
         current_label = new BMapGL.Label("你的位置大概在半径50m内", {
             offset: new BMapGL.Size(20, -10)
         });
         // label样式修改
         current_label.enableMassClear = true;
         current_label.setStyle({
			borderRadius: '5px',
			borderColor: '#ababab',
			padding: '3px 10px',
			fontSize: '12px',
			color: '#757676'
		});
        current_marker.setLabel(current_label); //添加百度label
         // 绘制圆
         circle_current_marker = new BMapGL.Circle(ggPoint, 40, {
            strokeColor: 'blue',
            fillColor: '#AEDCFC',
            strokeWeight: 1,
            strokeOpacity: 0.5,
            fillOpacity : 0.4
            });
        // map.addOverlay(circle_current_marker);
        map.addOverlay(current_marker);
        map.removeOverlay(circle_current_marker);
        map.removeOverlay(current_label);

         // 创建图文信息窗口
         var sContent = `
             <div>
                 <h4 style='margin:0 0 5px 0;'>你好啊</h4>
                 <img style='float:right;margin:0 4px 22px' id='imgDemo' src='https://gimg2.baidu.com/image_search/src=http%3A%2F%2Fi0.hdslb.com%2Fbfs%2Farticle%2F5e36477770bbac53ed4463f17daff48fd5e516fb.gif&refer=http%3A%2F%2Fi0.hdslb.com&app=2002&size=f9999,10000&q=a80&n=0&g=0n&fmt=jpeg?sec=1611211486&t=4dabc8a2db54a243c3062b28a5229b6d' width='139' height='104'/>
                 <p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em'>
                     今天不爽，今天不爽，今天不爽；成就感，成就感，成就感；未来，未来，未来
                     <p style="text-align: right;">2020-12-22</p>
                 </p>
             </div>
             `;
         var infoWindow = new BMapGL.InfoWindow(sContent);
         // marker添加点击事件
         current_marker.addEventListener('click', function () {
             this.openInfoWindow(infoWindow);
             // 图片加载完毕重绘infoWindow
             document.getElementById('imgDemo').onload = function () {
                 infoWindow.redraw(); // 防止在网速较慢时生成的信息框高度比图片总高度小，导致图片部分被隐藏
             };
         });
     }
 }

 function showText() {
     if (iii01[0] % 2 == 0) {
         map.setDisplayOptions({
             poiText: false
         })
     } else {
         map.setDisplayOptions({
             poiText: true
         })
     }
     iii01[0]++;

 }

 function showIcon() {

     if (iii01[1] % 2 == 0) {
         map.setDisplayOptions({
             poiIcon: false
         })
     } else {
         map.setDisplayOptions({
             poiIcon: true
         })
     }
     iii01[1]++;
 }

 function showPosition() {
     if (iii01[2] % 2 == 0) {
         marker_canteen.push(new BMapGL.Marker(new BMapGL.Point(116.041137, 28.683057)));
         marker_canteen.push(new BMapGL.Marker(new BMapGL.Point(116.036857, 28.68924)));
         marker_canteen.push(new BMapGL.Marker(new BMapGL.Point(116.037881, 28.690136)));
         marker_canteen.push(new BMapGL.Marker(new BMapGL.Point(116.032747, 28.687644)));
         // 在地图上添加点标记
         for (var i = 0; i < marker_canteen.length; i++) {
             map.addOverlay(marker_canteen[i]);
         }
     } else {
         for (var i = 0; i < marker_canteen.length; i++) {
             map.removeOverlay(marker_canteen[i]);
         }
         // map.removeOverlay();
         marker_canteen = [];

     }
     iii01[2]++;
 }

 function showPositionLine() {
     if (iii01[3] % 2 == 0) {
        map.addOverlay(polyline2);
     } 
     else {
        map.removeOverlay(polyline2);
     }
     iii01[3]++;
 }

 function showPositionYourself() {
     //显示坐标
     map.removeOverlay(current_marker);
     map.addOverlay(current_label);
     map.addOverlay(circle_current_marker);
     ggPoint = {};
     current_marker = {};
     current_label = {};
     circle_current_marker = {};
     console.log(circle_current_marker);
     //获取定位                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
     navigator.geolocation.getCurrentPosition(function (position) {
         ggPoint = new BMapGL.Point(position.coords.longitude, position.coords.latitude); 
         // 坐标转换并显示
         var convertor = new BMap.Convertor();
         var pointArr = [];
         pointArr.push(ggPoint);
         convertor.translate(pointArr, 1, 5, translateCallback2);
     });
     translateCallback2 = function (data) {
         if (data.status === 0) {
            // 创建小车图标
            var myIcon = new BMapGL.Icon("./img/1.svg", new BMapGL.Size(32, 32));
            current_marker = new BMapGL.Marker(data.points[0], {
                icon: myIcon,
            });
            ggPoint = data.points[0];
            map.addOverlay(current_marker);
            current_label = new BMapGL.Label("你的位置大概在半径50m内", {
                offset: new BMapGL.Size(20, -10)
            });
            // label样式修改
            current_label.enableMassClear = true;
            current_label.setStyle({
               borderRadius: '5px',
               borderColor: '#ababab',
               padding: '3px 10px',
               fontSize: '12px',
               color: '#757676'
           });
           current_marker.setLabel(current_label); //添加百度label
            // 绘制圆
            circle_current_marker = new BMapGL.Circle(ggPoint, 40, {
               strokeColor: 'blue',
               fillColor: '#AEDCFC',
               strokeWeight: 1,
               strokeOpacity: 0.5,
               fillOpacity : 0.4
               });
           map.addOverlay(current_marker);
        //    map.removeOverlay(circle_current_marker);
        //    map.removeOverlay(current_label);
   
            // 创建图文信息窗口
            var sContent = `
                <div>
                    <h4 style='margin:0 0 5px 0;'>位置</h4>
                    <img style='float:right;margin:0 4px 22px' id='imgDemo' src='https://gimg2.baidu.com/image_search/src=http%3A%2F%2Fhiphotos.baidu.com%2Ffeed%2Fpic%2Fitem%2F728da9773912b31bee73674c8a18367adab4e1bc.jpg&refer=http%3A%2F%2Fhiphotos.baidu.com&app=2002&size=f9999,10000&q=a80&n=0&g=0n&fmt=jpeg?sec=1611211005&t=8d9a2f38059d2b18b28dc833b47b6b12' width='139' height='104'/>
                    <p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em'>
                        你的位置，貌似有点误差，浏览器定位理解万岁...
                    </p>
                </div>
                `;
            var infoWindow = new BMapGL.InfoWindow(sContent);
            // marker添加点击事件
            current_marker.addEventListener('click', function () {
                this.openInfoWindow(infoWindow);
                // 图片加载完毕重绘infoWindow
                document.getElementById('imgDemo').onload = function () {
                    infoWindow.redraw(); // 防止在网速较慢时生成的信息框高度比图片总高度小，导致图片部分被隐藏
                };
            });
            // ggPoint = data.points[0];
            map.centerAndZoom(ggPoint, 19);
            // alert(666);
            // console.log(ggPoint);
        }
     }

     // 比例图标需要更新
 }

 function toolOpenClose() {
     var map_tool_infor = document.getElementById("map-tool-infor");
     if(iii01[5]%2==0) {
        map_tool_infor.style.display = "block";
     }
     else {
        map_tool_infor.style.display = "none";
     }
     iii01[5]++;
 }