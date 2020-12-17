 //位置信息
 var ggPoint;
 var map;
 //餐厅点坐标
 var marker_canteen = [];
 //poi文字、poi图标
 var iii01 = [0, 0, 0, 0, 0];
 var polyline;

 function loadJScript() {
     var script = document.createElement('script');
     script.type = 'text/javascript';
     script.src = 'https://api.map.baidu.com/api?type=webgl&v=1.0&ak=4ZdIV1KFQG8EqpNgn0c2OYdrVIGQnMTH&callback=init';
     document.body.appendChild(script);
 }
 window.onload = loadJScript; // 异步加载地图
 function init() {
     var static_point = new BMapGL.Point(116.038525, 28.68618);
     map = new BMapGL.Map('container'); // 创建Map实例
     map.enableScrollWheelZoom(); // 启用滚轮放大缩小
     map.centerAndZoom(static_point, 16);
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
     var navi3DCtrl = new BMapGL.NavigationControl3D();
     map.addControl(navi3DCtrl);
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
         // console.log('外轮廓：', rs.boundaries[0]);
         // console.log('内镂空：', rs.boundaries[1]);
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
         var marker = new BMapGL.Marker(ggPoint);
         map.addOverlay(marker);
         var label = new BMapGL.Label("转换后的百度坐标（不正确）", {
             offset: new BMapGL.Size(20, -10)
         });
         marker.setLabel(label); //添加百度label
         // 坐标转换并显示
         convertor();
     });

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
         var myIcon = new BMapGL.Icon("./img/1.png", new BMapGL.Size(52, 26));
         var marker = new BMapGL.Marker(data.points[0], {
             icon: myIcon,
             enableDragging: true,
         });
         ggPoint = data.points[0];
         map.addOverlay(marker);
         var label = new BMapGL.Label("转换后的百度坐标（正确）", {
             offset: new BMapGL.Size(20, -10)
         });
         marker.setLabel(label); //添加百度label

         // 创建图文信息窗口
         var sContent = `
             <div>
                 <h4 style='margin:0 0 5px 0;'>天安门</h4>
                 <img style='float:right;margin:0 4px 22px' id='imgDemo' src='https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1607689593112&di=c64c7fa131bff2f5caef27ada0ab9e1d&imgtype=0&src=http%3A%2F%2Fandroid-wallpapers.25pp.com%2Ffs01%2F2015%2F01%2F16%2F1%2F0_fb62a937483f05de07512842d3496144_900x675.jpg' width='139' height='104'/>
                 <p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em'>
                     天安门坐落在中国北京市中心,故宫的南侧,与天安门广场隔长安街相望,是清朝皇城的大门...
                 </p>
             </div>
             `;
         var infoWindow = new BMapGL.InfoWindow(sContent);
         // marker添加点击事件
         marker.addEventListener('click', function () {
             this.openInfoWindow(infoWindow);
             // 图片加载完毕重绘infoWindow
             document.getElementById('imgDemo').onload = function () {
                 infoWindow.redraw(); // 防止在网速较慢时生成的信息框高度比图片总高度小，导致图片部分被隐藏
             };
         });
         // 创建信息窗口
         // var opts = {
         //     width: 200,
         //     height: 100,
         //     title: '故宫博物院'
         // };
         // var infoWindow = new BMapGL.InfoWindow('地址：北京市东城区王府井大街88号乐天银泰百货八层', opts);
         // // 点标记添加点击事件
         // marker.addEventListener('click', function () {
         //     map.openInfoWindow(infoWindow, ggPoint); // 开启信息窗口
         // });
         // 获取标记点的坐标
         // alert(marker.getPosition(ggPoint).lat)
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
         // 

     }
     iii01[2]++;
 }

 function showPositionLine() {
     if (iii01[3] % 2 == 0) {
         map.addOverlay(polyline);
     } else {
         map.removeOverlay(polyline)
     }
     iii01[3]++;

 }

 function showPositionYourself() {
     // var geolocation = new BMap.Geolocation();
     // geolocation.getCurrentPosition(function (r) {
     //     if (this.getStatus() == BMAP_STATUS_SUCCESS) {
     //         var mk = new BMap.Marker(r.point);
     //         map.addOverlay(mk);
     //         // map.panTo(r.point);
     //         map.setZoom(20);
     //         map.setCenter(r);
     //         // alert('您的位置：' + r.point.lng + ',' + r.point.lat);
     //     } else {
     //         alert('failed' + this.getStatus());
     //     }
     // }, {
     //     enableHighAccuracy: true
     // })
     // var pointtest = new 
     // map.setCenter(marker_canteen[1]); // 设置地图中心点


     //获取定位
     navigator.geolocation.getCurrentPosition(function (position) {
         // 坐标转换
         ggPoint = new BMapGL.Point(position.coords.longitude, position.coords.latitude);

         // 标注
         var marker = new BMapGL.Marker(ggPoint);
         map.addOverlay(marker);
         var label = new BMapGL.Label("转换后的百度坐标（不正确）", {
             offset: new BMapGL.Size(20, -10)
         });
         marker.setLabel(label); //添加百度label
         // 坐标转换并显示
         var convertor = new BMap.Convertor();
         var pointArr = [];
         pointArr.push(ggPoint);
         convertor.translate(pointArr, 1, 5, translateCallback2);
     });
     translateCallback2 = function (data) {
         if (data.status === 0) {
             console.log(data);
             ggPointest = data.points[0];
             // map.setCenter(ggPointest);
             map.centerAndZoom(ggPointest, 19);
             // map.setCenter(ggPointest);
             // map.setZoom(20);
         }
     }

     // 比例图标需要更新
 }