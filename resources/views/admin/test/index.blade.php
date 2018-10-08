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
    <script>
        function initPicList(handle, id, name, srcUrl, thumbUrl, withDelete) {
            $("#"+id).prepend('<div class="imguploader-doneitem" style="width: 100px;height: 100px">\n' +
                '      <a class="fancybox" href="'+srcUrl+'" rel="group">\n' +
                '        <img src="'+thumbUrl+'">\n' +
                '      </a>\n' + (withDelete? '      <span class="imguploader-delbtn">×</span>\n': '') +
                '      <span class="imguploader-progress" style="width: 100%; display: none;"></span>\n' +
                '      <input name="'+name+'_preview[]" class="'+name+'_preview" value="'+srcUrl+'" type="hidden">\n' +
                '      <input name="'+name+'_thumb[]" class="'+name+'_thumb" value="'+thumbUrl+'" type="hidden">\n' +
                '    </div>')
        }
        alert(uploadhandle.imgNum)
        initPicList(uploadhandle, 'container', 'main_files', 'http://static.huijiayi.com.cn/liwudao/upload/image/20180928/7869849425.jpg', 'http://static.huijiayi.com.cn/liwudao/upload/image/20180928/7869849425.jpg', 1);
        initPicList(uploadhandle, 'container', 'main_files', 'http://static.huijiayi.com.cn/liwudao/upload/image/20180928/7869849425.jpg', 'http://static.huijiayi.com.cn/liwudao/upload/image/20180928/7869849425.jpg', 1);
        uploadhandle.target.hidden();
    </script>
@endsection
