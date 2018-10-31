@extends('front.article.main')
@section('title', '终稿考政策')
@section('body_content')
    <script>
        var pageCode = '';
        $.post(
            '{{ $pull_url }}',
            {code: pageCode},
            function (result) {
            }
        )
    </script>
@endsection