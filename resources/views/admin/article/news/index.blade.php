@extends('admin.layouts.main')
@section('title', '教育新闻列表-教育新闻-文章管理中心')
@section('body_content')
    <link href="/assets/stylesheets/common.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/assets/stylesheets/font-awesome.css" media="all" rel="stylesheet" type="text/css" />
    @include('admin.menus.article.news_menu', ['menu' => $menu, 'admin_info' => $admin_info, 'ts_list' => $ts_list])

    <div class="container-fluid main-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="widget-container fluid-height clearfix">
                    <div class="widget-content padded clearfix">
                        <p>教育新闻列表</p>
                        <table class="table table-bordered table-striped" id="dataTable1">
                            <thead>
                                <th width="10%">ID</th>
                                <th width="25%">标题</th>
                                <th width="10%">显示状态</th>
                                <th width="20%">创建时间</th>
                                <th width="20%">发布时间</th>
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
                                        {{ $value->created_at }}
                                    </td>
                                    <td>
                                        {{ $value->published_at }}
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
        </script>
    @endif
@endsection
