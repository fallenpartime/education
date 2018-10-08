@extends('admin.layouts.main')
@section('title', 'test')
@section('body_content')
    <link rel="stylesheet" href="/assets/stylesheets/imgUploader.min.css">
    <style>
        #upbtn {
            width: 100px;
            height: 100px;
        }
    </style>
    <script src="/assets/javascripts/imgUploader.min.js"></script>
    <div id="container">
        <div id="upbtn">
            <div id="utbtn-ipt"></div>
        </div>
    </div>
    <script>
        var url = '{{ route('upload') }}';
        var uploadhandle = new ImgUploader({
            handler  : 'upbtn',
            target   : 'utbtn-ipt',
            container: 'container',
            url      : url,
            imgNum   : 1,
            key      : 'main_files'
        })
    </script>
@endsection
