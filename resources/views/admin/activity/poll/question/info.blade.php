@extends('admin.layouts.main')
@section('title', '网络投票活动配置-网络投票活动-活动管理中心')
@section('body_content')
    @include('admin.layouts.picture')
    <link href="/assets/stylesheets/common.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/assets/stylesheets/font-awesome.css" media="all" rel="stylesheet" type="text/css" />
    <script src="/assets/javascripts/WdatePicker.js" type="text/javascript"></script>
    @include('admin.menus.activity.poll_menu', ['menu' => $menu, 'admin_info' => $admin_info, 'ts_list' => $ts_list])
    <style>
        #list-up {
            width: 100px;
            height: 100px;
        }
    </style>
    <div class="container-fluid main-content">
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-lg-12">
                <div class="widget-container fluid-height clearfix search-window">
                    <form id="articleForm" action="" method="post" onsubmit="return false;">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ !empty($record)? $record->id: '' }}">
                        <div class="medical-box col-sm-10 col-md-10 col-lg-10" style="height: auto; padding-bottom: 5px;">
                            <p>
                                问题配置
                            </p>
                            <div class="medical-list" >
                                <div class="medical-div">
                                    <p style="width: 50%; display: inline; margin-right: 10px;">
                                        <span>活动ID:</span>
                                        <input type="text" name="activity_id" value="{{ !empty($activityId)? $activityId: '' }}" required="required" placeholder="请输入活动ID" style="width: 40%;"/>
                                    </p><br/>
                                    <p style="width: 100%; margin-right: 10px;">
                                        <span>资源类型:</span>
                                        <input type="radio" name="type" value="0" @if(!empty($record) && $record->type == 0) checked @endif />文字&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" name="type" value="1" @if(!empty($record) && $record->type == 1) checked @endif />图片
                                    </p><br/>
                                    <p style="width: 50%; display: inline; margin-right: 10px;">
                                        <span>问题标题:</span>
                                        <input type="text" name="title" value="{{ !empty($record)? $record->title: '' }}" placeholder="请输入问题标题" style="width: 40%;"/>
                                    </p><br/>
                                    <p style="margin-bottom: 0;float: left">
                                        <span>图片:</span>
                                    </p>
                                    <div id="list-container" style="overflow: hidden;width: 80%;float: left">
                                        <div id="list-up">
                                            <div id="utbtn-ipt"></div>
                                        </div>
                                    </div>
                                    <br/>
                                    <p style="width: 100%; margin-right: 10px;">
                                        <span>是否多选:</span>
                                        <input type="radio" name="is_checkbox" value="0" @if(!empty($record) && $record->is_checkbox == 0) checked @endif/>否&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" name="is_checkbox" value="1" @if(!empty($record) && $record->is_checkbox == 1) checked @endif/>是
                                    </p><br/>
                                    <p style="width: 100%;"></p><br/>
                                </div>
                            </div>
                        </div>

                        <p class="deposit">
                            <input type="submit" name="submit" value="保存" onclick="articleSave();"/>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        var uploadhandle = new ImgUploader({
            handler  : 'list-up',
            target   : 'utbtn-ipt',
            container: 'list-container',
            url      : uploadUrl,
            imgNum   : 1,
            key      : 'list_pic'
        })
    </script>
    <script>
        @if(!empty($record) && !empty($record->source))
        initPictureList(uploadhandle, 'list-up', 'list_pic', '{{ $record->source }}', '{{ $record->source }}', 1);
        @endif
    </script>
    <script>
        function articleSave() {
            if (confirm('确定提交？')) {
                $.post(
                    '{{ $actionUrl }}',
                    $('#articleForm').serialize(),
                    function (result) {
                        result = JSON.parse(result)
                        if (result.code == 200) {
                            location.href=document.referrer;
                        } else {
                            alert(result.msg)
                        }
                    }
                )
            }
        }
    </script>
@endsection
