<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="/assets/css/app.css">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=BzhKkTniDZS9bPzFpLGTAG2UDSTocLHm"></script>
    <!-- 控制区域显示js -->
    <script type="text/javascript" src="http://api.map.baidu.com/library/AreaRestriction/1.2/src/AreaRestriction_min.js"></script>
    <script src="/assets/javascripts/jquery-1.10.2.min.js" type="text/javascript"></script>

</head>
<body>
    <div id="container"></div>
    <div class="search_box">
        <form method="post">
            <div>输入搜索的内容:</div><input type="text" id="search" name="topic" autocomplete="off" placeholder="请输入学校名称查询">
        </form>
        <ul class="search_results" id="search_results"></ul>
    </div>
    <script type="text/javascript">
        var map = new BMap.Map("container");    // 创建Map实例
        var point = new BMap.Point(120.38, 36.07);    //创建中心点坐标
        map.centerAndZoom(point,15);
        map.enableScrollWheelZoom();
        map.addControl(new BMap.NavigationControl());
    </script>
    <script>
        var pointList = [];
        var infoList = [];
        function openMapWindow(infoWindow, point) {
            map.openInfoWindow(infoWindow, point);
        }

        function addResultItem(id, title) {
            $("#search_results").addChild('<li onmousemove="openMapWindow(infoList['+id+'], pointList['+id+'])"><a href="#">'+title+'</a></li>');
        }
        function addMarker(id, point){
            var marker = new BMap.Marker(point);
            map.addOverlay(marker);
            marker.enableDragging();
            marker.addEventListener("mouseover", function(){this.openInfoWindow(infoList[id]);});
        }
        $(function(){
            $('#search').val('');
            $(window).click(function(event) {
                $('.search_results').css('display','none');
            });
            $('#search, .search_results li').click(function(e) {
                e.stopPropagation();
            });
            $('#search').keyup(function(event) {
                event.stopPropagation();
                $.ajax({
                    url: '{{ route('front.school.district.search') }}',
                    type: 'post',
                    data: $("form").serialize(),
                    success: function(response, status, xhr){
                        console.log(response);
                        response = JSON.parse(response)
                        if (response.code == 0) {
                            return false;
                        }
                        var list = response.result;
                        for (var sid in list) {
                            var item = list[sid];
                            if (item.lng == 0 && item.lat == 0) {
                                continue;
                            }
                            point = new BMap.Point(item.lng, item.lat);
                            pointList[sid] = point;
                            var infoContent =
                                "<h4>学校名称:</h4>" +item.name + "<br>" +
                                "<h4>学校地址:</h4>" +item.address + "<br>" +
                                "<h4>学校电话:</h4>" +item.telent + "<br>" +
                                "<h4>学校性质:</h4>" +item.property + "<br>" +
                                "<h4>学校学区:</h4>" +item.district + "<br>";
                            var infoWindow = new BMap.InfoWindow(infoContent);
                            infoList[sid] = infoWindow;
                            addMarker(sid, point);
                            // infoList[sid] = "";
                            // 'name'      =>  $item->name,
                            //     'address'   =>  $item->address,
                            //     'telent'    =>  $item->telent,
                            //     'district'  =>  $districtName,
                            //     'lng'       =>  $lng,
                            //     'lat'       =>  $lat,
                            //     'property'  =>  '',
                        }
                    }
                })
                .done(function() {
                    console.log("success");
                })
                .fail(function() {
                    console.log("error");
                })
                .always(function() {
                    console.log("complete");
                })
            });
        });
    </script>
</body>
</html>
