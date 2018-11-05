<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0,viewport-fit=cover">
    <title>投票提交回馈</title>
    <link rel="stylesheet" type="text/css" href="/assets/front/css/main.css">
    <link rel="stylesheet" type="text/css" href="/assets/front/css/vote.css">
    <link rel="stylesheet" type="text/css" href="/assets/front/css/iconfont.css">
</head>
<body>
    <div class="container">
        <div class="active-panel">
            <div class="active-desc">
                <img src="/assets/front/images/404.jpg" alt="" style="width: 80%;">
                <h3>{{ $content }}</h3>
            </div>
        </div>
    </div>
    <script>
        function redirect() {
            location.href="{{ $redirectUrl }}";
        }
        setTimeout(redirect, 3000)
    </script>
</body>
</html>