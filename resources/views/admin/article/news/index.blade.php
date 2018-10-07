@extends('admin.layouts.main')
@section('title', '教育新闻列表-教育新闻-文章管理中心')
@section('body_content')
    <link href="/assets/stylesheets/common.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/assets/stylesheets/font-awesome.css" media="all" rel="stylesheet" type="text/css" />
    @include('admin.menus.article.news_menu', ['menu' => $menu, 'admin_info' => $admin_info, 'ts_list' => $ts_list])
@endsection