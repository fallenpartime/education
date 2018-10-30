@extends('front.article.main')
@section('title', '网络投票')
@section('body_content')
    <script>
        var pageCode = '';
        $.post(
            '/front/activity/polls',
            {code: pageCode},
            function (result) {
            }
        )
    </script>
@endsection