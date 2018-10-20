@extends('admin.layouts.main')
@section('title', '中高考政策列表-中高考政策-文章管理中心')
@section('body_content')
    <link href="/assets/stylesheets/common.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/assets/stylesheets/font-awesome.css" media="all" rel="stylesheet" type="text/css" />
    @include('admin.menus.article.exam_menu', ['menu' => $menu, 'admin_info' => $admin_info, 'ts_list' => $ts_list])

    <div class="container-fluid main-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="widget-container fluid-height clearfix">
                    <div class="widget-content padded clearfix">
                        <p>中高考政策列表</p>
                        <table class="table table-bordered table-striped" id="dataTable1">
                            <thead>
                                <th width="10%">ID</th>
                                <th width="15%">标题</th>
                                <th width="10%">显示状态</th>
                                <th width="5%">阅读数</th>
                                <th width="5%">点赞数</th>
                                <th width="15%">创建时间</th>
                                <th width="15%">发布时间</th>
                                <th width="10%">列表头图</th>
                                <th width="15%">操作</th>
                            </thead>
                            <tbody style="text-align: center;">
                            @foreach($list as $key => $value)
                                <tr>
                                    <td>
                                        {{ $value->id }}
                                    </td>
                                    <td style="text-align:left;word-break: break-all; word-wrap:break-word;">
                                        {{ $value->title }}
                                    </td>
                                    <td style="color:@if($value->is_show) green @else red @endif;">
                                        @if($value->is_show) 显示 @else 隐藏 @endif
                                    </td>
                                    <td>
                                        {{ $value->read_count }}
                                    </td>
                                    <td>
                                        {{ $value->like_count }}
                                    </td>
                                    <td>
                                        {{ $value->created_at }}
                                    </td>
                                    <td>
                                        {{ $value->published_at }}
                                    </td>
                                    <td>
                                        @if(!empty($value->list_pic))
                                            <a href="{{ $value->list_pic }}" target="_blank"><img src="{{ $value->list_pic }}" style="width: 100px; height: 100px;"/></a>
                                        @endif
                                    </td>
                                    <td>
                                        @if($value->operate_list['allow_operate_edit'])
                                            <a href="{{ $value->edit_url }}" style="display: block;">编辑</a>
                                        @endif
                                        @if($value->operate_list['allow_operate_change'])
                                            <a href="javascript:;" style="display: block;" onclick="changeShow({{ $value->id }})">
                                                @if($value->is_show) 隐藏 @else 显示 @endif
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($operateList['change_show'])
        <script>
            function changeShow(id) {
                if (confirm('确定提交？')) {
                    $.post(
                        '{{ $operateUrl['change_url'] }}',
                        {id: id},
                        function (result) {
                            result = JSON.parse(result)
                            if (result.code == 200) {
                                location.href = '{{ $redirectUrl }}';
                            } else {
                                alert(result.msg)
                            }
                        }
                    )
                }
            }
        </script>
    @endif
@endsection
