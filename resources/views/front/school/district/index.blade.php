<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <style type="text/css">
        body, html{width: 100%;height: 100%; margin:0;font-family:"微软雅黑";}
        #l-map{height: 95%;width:100%;}
        #r-search{height:45px;width:100%;}
    </style>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=BzhKkTniDZS9bPzFpLGTAG2UDSTocLHm"></script>
    <script src="/assets/javascripts/jquery-1.10.2.min.js" type="text/javascript"></script>
    <title>本地搜索的结果面板</title>
</head>
<body>
    <div id="r-search">
        <label for="" class="serchBtn">
            <input type="text" id="topic" placeholder="搜索学校" name='keyword' id="schoolName">
            <i class="submitBtn"></i>
        </label>
    </div>
    <div id="l-map"><input type="text" id="topic" placeholder="请输入学校名称"/></div>
    <link rel="stylesheet" href="/assets/front/css/index.css">
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</body>
</html>
<script type="text/javascript">
    // 百度地图API功能
    var map = new BMap.Map("l-map");            // 创建Map实例
    map.centerAndZoom(new BMap.Point(120.38, 36.07), 11);
    map.enableScrollWheelZoom();
    map.addControl(new BMap.NavigationControl());  //添加默认缩放平移控件
    var checkUrl = "{{ route('front.school.district.search') }}";
    var infoList = {};
    function clearAll() {
        for (var i = 0; i < map.getOverlays().length; i++) {
            map.removeOverlay(map.getOverlays()[i]);
        }
    }
    function search(school) {
        $(function () {
            if (map.getOverlays().length > 0) {
                clearAll();
            }
            $.post(
                checkUrl,
                {topic: school},
                function (response) {
                    response = JSON.parse(response);
                    for(var itemid in response.result){
                        //alert(data.data[item].longitude);
                        item = response.result[itemid]
                        var longitude=item.lng;
                        var latitude=item.lat;
                        if(longitude!=0 || latitude!=0 ){
                            point =new BMap.Point(longitude,latitude);
                            infoList[itemid] = new BMap.InfoWindow("<div>" +
                                "<h6 style='margin:0 0 5px 0;padding:0.2em 0'>学校名称:" +item.name + "</h6>" +
                                "<h6 style='margin:0 0 5px 0;padding:0.2em 0'>学校地址:" +item.address + "</h6>" +
                                "<h6 style='margin:0 0 5px 0;padding:0.2em 0'>学校电话:" +item.telent + "</h6>" +
                                "<h6 style='margin:0 0 5px 0;padding:0.2em 0'>学校学区:" +item.district + "</h6>" +
                                "<h6 style='margin:0 0 5px 0;padding:0.2em 0'>学校属性:" +item.property + "</h6>" +
                                "</div>");
                            function addMarker(point){
                                var marker = new BMap.Marker(point);
                                map.addOverlay(marker);
                                marker.enableDragging();
                                marker.id = itemid
                                marker.addEventListener("click", function() {
                                    this.openInfoWindow(infoList[this.id]);
                                })
                            }
                            addMarker(point);

                        }
                    }//.for(
                }
            )
        })
    }
    $(".submitBtn").click(function () {
        var schoolName = $("#topic").val();
        search(schoolName);
    })
</script>
