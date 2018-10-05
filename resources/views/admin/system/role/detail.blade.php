@extends('admin.layouts.main')
@section('title', '角色详情-角色管理-权限中心')
@section('body_content')
    <link href="/assets/stylesheets/common.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/assets/stylesheets/font-awesome.css" media="all" rel="stylesheet" type="text/css" />
    @include('admin.menus.admin_role_menu', ['menu' => $menu, 'admin_info' => $admin_info, 'ts_list' => $ts_list])
    <form id="userForm" action="#" method="post" onsubmit="return false">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ !empty($record)? $record->id: 0 }}" />
        <!--内容-->
        <div class="container-fluid main-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="widget-container fluid-height clearfix">
                        <div class="widget-content padded clearfix">
                            <p>角色详情</p>
                            <table class="table table-bordered table-striped table-hover" id="">
                                <thead>
                                <th width="30%">标题</th>
                                <th width="65%">内容</th>
                                </thead>
                                <tbody style="text-align: center;">
                                <tr>
                                    <td>角色编号</td>
                                    <td style="text-align: left"><input type="text" name="no" style="width: 60%" value="{{ !empty($record)? $record->role_no: '' }}"/></td>
                                </tr>
                                <tr>
                                    <td>角色名称</td>
                                    <td style="text-align: left"><input type="text" name="name" style="width: 60%" value="{{ !empty($record)? $record->name: '' }}"/></td>
                                </tr>
                                <tr>
                                    <td>入口</td>
                                    <td style="text-align: left">
                                        <select id="indexurl" name="indexurl" style="width: 30%;">
                                            <option value="">请选择</option>
                                            @if(!empty($indexUrls))
                                                @foreach($indexUrls as $indexTag => $indexUrl)
                                                    <option value="{{ $indexTag }}" @if(!empty($record) && $record->index_action == $indexTag)selected="selected"@endif>{{ $indexUrl['title'] }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </td>
                                </tr>
                                @if(!empty($groups))
                                    @foreach($groups as $group)
                                    <?php
                                        $groupModel = $group['model'];
                                        $access = $group['access'];
                                    ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="{{ $groupModel->tip }}" value="{{ $groupModel->group_no }}" @if(!empty($access))checked="checked"@endif/>&nbsp;{{ $groupModel->name }}分组</td>
                                        </td>
                                        <td style="text-align: left">
                                            <input type="checkbox" name="{{ $groupModel->tip }}_leader" value="1" @if(!empty($access) && $access->is_leader ==1)checked="checked"@endif/>是否组长
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <span>主管角色</span>
                                            <select name="{{ $groupModel->tip }}_leader_no">
                                                <option value="0"></option>
                                                @if(!empty($roles))
                                                    @foreach($roles as $roleItem)
                                                        <option value="{{ $roleItem->no }}" @if(!empty($access) && $roleItem->role_no == $access->leader_no)selected="selected"@endif>{{ $roleItem->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                                @if(!empty($record))
                                <tr>
                                    <td>创建时间</td>
                                    <td style="text-align: left">
                                        {{ $record->created_at }}
                                    </td>
                                </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--角色权限-->
        <div class="container-fluid main-content">
            @include('admin.system.role.checked_list', ['authorities' => $authorities, 'groupAuthorities' => $groupAuthorities])
        </div>
        <!-- 提交 -->
        <div class="container-fluid main-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="widget-container fluid-height clearfix">
                        <div class="widget-content padded clearfix">
                            <table class="table table-bordered table-striped table-hover" id="">
                                <tr>
                                    <td colspan="3">
                                        <input type="submit" value="保存" onclick="roleSave();" style="margin-left: 20px;margin-right: 20px;"/>
                                        <a href="javascript:;" onclick="location.href=document.referrer;" style="margin-left: 20px;margin-right: 20px;">返回</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        function roleSave() {
            if (confirm('确定提交？')) {
                $.post(
                    '{{ $actionUrl }}',
                    $('#userForm').serialize(),
                    function (result) {
                        result = JSON.parse(result)
                        if (result.code == 200) {
                            var redirectUrl = '{{ $redirectUrl }}';
                            location.href=redirectUrl;
                        } else {
                            alert(result.msg)
                        }
                    }
                )
            }
        }
    </script>
@endsection