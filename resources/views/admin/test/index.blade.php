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
            imgNum   : 2,
            key      : 'main_files'
        })
    </script>
    @include('admin.layouts.picture')
    <script>
        initPictureList(uploadhandle, 'container', 'main_files', 'http://static.huijiayi.com.cn/liwudao/upload/image/20180928/7869849425.jpg', 'http://static.huijiayi.com.cn/liwudao/upload/image/20180928/7869849425.jpg', 1);
        // initPictureList(uploadhandle, 'container', 'main_files', 'http://static.huijiayi.com.cn/liwudao/upload/image/20180928/7869849425.jpg', 'http://static.huijiayi.com.cn/liwudao/upload/image/20180928/7869849425.jpg', 1);
    </script>
@endsection
