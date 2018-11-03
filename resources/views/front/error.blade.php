<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0,viewport-fit=cover">
    <title></title>
    <link rel="stylesheet" type="text/css" href="/assets/front/css/main.css">
    <link rel="stylesheet" type="text/css" href="/assets/front/css/vote.css">
    <link rel="stylesheet" type="text/css" href="/assets/front/css/iconfont.css">
</head>
<body>
<div class="container">
    <div class="active-panel">
        <div class="active-background">
            <div class="vote-entrance"></div>
        </div>
        <div class="active-desc">
            <h3>{{ $msg }}</h3>
        </div>
    </div>
</div>
@if(!empty($url))
<script>
    function redirect() {
        location.href="{{ $url }}";
    }
    setTimeout(redirect, 2000)
</script>
@endif
</body>
</html>