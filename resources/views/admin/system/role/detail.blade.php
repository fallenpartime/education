@extends('admin.layouts.main')
@section('title', '角色详情-角色管理-权限中心')
@section('body_content')
    <link href="/assets/stylesheets/common.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/assets/stylesheets/font-awesome.css" media="all" rel="stylesheet" type="text/css" />
    @include('admin.menus.admin_role_menu', ['menu' => $menu, 'admin_info' => $admin_info, 'ts_list' => $ts_list])
@endsection