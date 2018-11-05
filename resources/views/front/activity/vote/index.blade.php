<html>
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0,viewport-fit=cover">
    <title>师生风采-详情</title>
    <link rel="stylesheet" type="text/css" href="/assets/front/css/main.css">
    <link rel="stylesheet" type="text/css" href="/assets/front/css/vote.css">
    <link rel="stylesheet" type="text/css" href="/assets/front/css/iconfont.css">
    <title>我要投票</title>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</head>
<body>
<div class="container">
    <div class="active-panel">
        <div class="active-background">
            <div class="vote-entrance"></div>
        </div>
        <div class="active-desc">
            <h3>{{ array_get($record, 'title') }}</h3>
            <p>{{ array_get($record, 'description') }}</p>
        </div>
    </div>
    <div class="active-con">
        <form method="post" action="" id="vote-form">
            <ul class="vote-list">
                @foreach($questions as $question)
                    <p>@if($question->type==0){{ $question->title }}@else<img src="{{ $question->source }}"/>@endif</p>
                    @if(!is_null($question->answers))
                        @foreach($question->answers as $answer)
                            <li class="vote-item">
                                @if($question->is_checkbox)
                                <input type="checkbox" name="answer_box[]" value="{{ "{$question->id}-{$answer->id}" }}" /><span>{{ $answer->title }}</span>
                                @else
                                <input type="radio" name="answer_single[{{ $question->id }}]" value="{{ "{$question->id}-{$answer->id}" }}" /><span>{{ $answer->title }}</span>
                                @endif
                            </li>
                        @endforeach
                        <li class="vote-item">
                            <input type="text" name="answer_other[{{ $question->id }}]" value="" placeholder="其他">
                        </li>
                    @endif
                @endforeach
            </ul>
            <a class="sub-btn">提&nbsp;&nbsp;&nbsp;交</a>
        </form>
    </div>
</div>
</body>
<script src="/assets/javascripts/jquery-1.10.2.min.js" type="text/javascript"></script>
<script>
    $(function(){
        $('.sub-btn').click(function(){
            $.ajax({
                url:"{{ $vote_url }}",
                type:"post",
                data: $("#vote-form").serialize(),
                success:function(data){
                    data = JSON.parse(data)
                    if (data.code == 200) {
                        location.href = data.data.url;
                    }
                },
                error:function(e){
                    alert("错误！！");
                }
            })
        })

    })
</script>
</html>