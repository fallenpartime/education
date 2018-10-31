@extends('front.article.main')
@section('title', '教研活动')
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