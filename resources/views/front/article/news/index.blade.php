@extends('front.article.main')
@section('title', '教育快讯')
@section('body_content')
    <script>
        var pageCode = '';
        $.post(
            '/front/article/news',
            {code: pageCode},
            function (result) {
            }
        )
    </script>
@endsection