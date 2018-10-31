@extends('front.article.main')
@section('title', '教育快讯')
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