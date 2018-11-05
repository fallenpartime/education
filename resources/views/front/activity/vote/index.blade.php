<html>
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0,viewport-fit=cover">
    <title>活动投票</title>
    <link rel="stylesheet" type="text/css" href="/assets/front/css/main.css">
    <link rel="stylesheet" type="text/css" href="/assets/front/css/vote.css">
    <link rel="stylesheet" type="text/css" href="/assets/front/css/iconfont.css">
    <script src="/assets/javascripts/jquery-1.10.2.min.js" type="text/javascript"></script>
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
        <div class="main">
            <div class="sug-title">投票</div>
            <form action="" method="" id="vote-form">
            {{ csrf_field() }}
            @foreach($questions as $question)
                <p>@if($question->type==0){{ $question->title }}@else<img src="{{ $question->source }}"/>@endif</p>
                <div class="panel vote-panel">
                    <div class="panel-title">@if($question->type==0){{ $question->title }}@else<img src="{{ $question->source }}"/>@endif</div>
                    <div class="vote-type">
                        @if(!is_null($question->answers))
                            @foreach($question->answers as $answer)
                                <label for="" class="vote-item">
                                    @if($question->is_checkbox)
                                        <input type="checkbox" name="answer_box[]" value="{{ "{$question->id}-{$answer->id}" }}" /><span></span>{{ $answer->title }}
                                    @else
                                        <input type="radio" name="answer_single[{{ $question->id }}]" value="{{ "{$question->id}-{$answer->id}" }}" /><span></span>{{ $answer->title }}
                                    @endif
                                </label>
                            @endforeach
                        @endif
                        <input type="text" name="answer_other[{{ $question->id }}]" value="" placeholder="其他">
                    </div>
                </div>
            @endforeach
            <div class="panel vote-panel">
                <div class="panel-title">请写出您的想法</div>
                <div class="vote-type">
                    <textarea name="" id="" cols="10" rows="10" placeholder="请写出您的想法"></textarea>
                </div>
            </div>
            <a href="javascript:void(0)" class="sub-btn">提交</a>
            </form>
        </div>
        <div class="alert" style="display: none">
            提交成功
        </div>
    </div>
</body>
<script>
    $(function(){
        $('.sub-btn').click(function(){
            $.ajax({
                url:"{{ $vote_url }}",
                type:"post",
                data: $("#vote-form").serialize(),
                success:function(data){
                    data = JSON.parse(data)
                    location.href = data.data.url;
                },
                error:function(e){
                    alert("错误！！");
                }
            })
        })

    })
</script>
</html>