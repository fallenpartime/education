@extends('front.article.main')
@section('title', '社会实践记录')
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