@extends('front.activity.main')
@section('title', '网络投票')
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