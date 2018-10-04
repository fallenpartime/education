<link href="/assets/stylesheets/font-awesome.css" media="all" rel="stylesheet" type="text/css" />
<div class="navbar navbar-fixed-top">
    <div class="container-fluid main-nav clearfix">
        <div class="nav-collapse" style="position:relative;">
            <img src="/assets/logo/logo.png" style="height: 35px;width: 150px;position: absolute;left:20px;top:18px;"/>
            <ul class="nav">
                @if(!empty($admin_info['is_manager'] || in_array('manageCenter', $ts_list)))
                <li class="dropdown">
                    <a data-toggle="dropdown" href="#" @if(in_array('manageCenter', $menu)) class="current"@endif >
                        <span aria-hidden="true" class="se7en-tables"></span>权限中心<b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        @if(!empty($admin_info['is_manager'] || in_array('groupManage', $ts_list)))
                            <li>
                                <a href="{{ array_get($menu_urls, 'manageCenter.groupManage') }}" @if(in_array('groupManage', $menu)) class="current"@endif>分组管理</a>
                            </li>
                        @endif
                        @if(!empty($admin_info['is_manager'] || in_array('authorityManage', $ts_list)))
                        <li>
                            <a href="{{ array_get($menu_urls, 'manageCenter.authorityManage') }}" @if(in_array('authorityManage', $menu)) class="current"@endif>权限管理</a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
                <li>
                    <a href="{{ route('admin.login') }}">
                        <span aria-hidden="true" class="se7en-home"></span>
                        退出登录
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>