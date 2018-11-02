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
            <div>输入搜索的内容:</div><input type="text" id="search" name="topic" autocomplete="off" placeholder="请输入序号，地址，或名称查询">
        </form>
        <ul class="search_results"></ul>
    </div>
    <script type="text/javascript">
        var map = new BMap.Map("container");    // 创建Map实例
        var point = new BMap.Point(116.404, 39.915);    //创建中心点坐标
        map.centerAndZoom(point, 14);    //初始化地图,设置中心点坐标和地图级别

        function openMyWin(id,p){
            map.openInfoWindow(id,p);
        }
    </script>
    <!-- 文本框搜索交互代码 -->
    <script type="text/javascript" src="/assets/front/map/js/index.js"></script>
</body>
</html>
