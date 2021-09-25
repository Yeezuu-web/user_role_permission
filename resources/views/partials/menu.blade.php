<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            {{ trans('panel.site_title') }}
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item {{ request()->is("admin") ? "active" : "" }}">
                <a href="{{ route("admin.home") }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">{{ trans('global.dashboard') }}</span>
                </a>
            </li>
            <li class="nav-item nav-category">Applications</li>
            @can('department_access') 
                <li class="nav-item {{ request()->is("admin/departments") || request()->is("admin/departments/*") ? "active" : "" }}">
                    <a href="{{ route("admin.departments.index") }}" class="nav-link">
                        <i class="link-icon" data-feather="trello"></i>
                        <span class="link-title">{{ trans('global.department') }}</span>
                    </a>
                </li>
            @endcan
            @can('channel_access') 
                <li class="nav-item {{ request()->is("admin/channels") || request()->is("admin/channels/*") ? "active" : "" }}">
                    <a href="{{ route("admin.channels.index") }}" class="nav-link">
                        <i class="link-icon" data-feather="tv"></i>
                        <span class="link-title">{{ trans('global.channel') }}</span>
                    </a>
                </li>
            @endcan
            <li class="nav-item nav-category">Boost System</li>
            @can('boost_access') 
                <li class="nav-item {{ request()->is("admin/boosts") || request()->is("admin/boosts/*") ? "active" : "" }}">
                    <a href="{{ route("admin.boosts.index") }}" class="nav-link">
                        <i class="link-icon" data-feather="trending-up"></i>
                        <span class="link-title">{{ trans('global.boost') }}</span>
                    </a>
                </li>
            @endcan
            <li class="nav-item nav-category">Settings</li>
            @can('user_management_access')
                <li class="nav-item {{ request()->is("admin/permissions*") ? "active" : "" }} {{ request()->is("admin/roles*") ? "active" : "" }} {{ request()->is("admin/users*") ? "active" : "" }}">
                    <a class="nav-link" data-toggle="collapse" href="#user-management" role="button" aria-expanded="{{ request()->is("admin/permissions*") ? "true" : "false" }} {{ request()->is("admin/roles*") ? "true" : "false" }} {{ request()->is("admin/users*") ? "true" : "false" }}" aria-controls="user-management">
                        <i class="link-icon" data-feather="users"></i>
                        <span class="link-title">{{ trans('cruds.userManagement.title') }}</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>
                    </a>
                    <div class="collapse {{ request()->is("admin/permissions*") ? "show" : "" }} {{ request()->is("admin/roles*") ? "show" : "" }} {{ request()->is("admin/users*") ? "show" : "" }}" id="user-management">
                        <ul class="nav sub-menu">
                            @can('permission_access')
                            <li class="nav-item"> 
                                <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "active" : "" }}">{{ trans('cruds.permission.title') }}</a>
                            </li>
                            @endcan
                            @can('role_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "active" : "" }}">{{ trans('cruds.role.title') }}</a>
                            </li>
                            @endcan
                            @can('user_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "active" : "" }}">{{ trans('cruds.user.title') }}</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            @endcan
            @can('user_alert_access')
                <li class="nav-item {{ request()->is("admin/user-alerts") || request()->is("admin/user-alerts/*") ? "active" : "" }}">
                    <a href="{{ route("admin.user-alerts.index") }}" class="nav-link">
                        <i class="link-icon" data-feather="bell"></i>
                        <span class="link-title">{{ trans('cruds.userAlert.title') }}</span>
                    </a>
                </li>
            @endcan
            @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                @can('profile_password_edit')
                    <li class="nav-item {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}">
                        <a href="{{ route('profile.password.edit') }}" class="nav-link">
                            <i class="link-icon" data-feather="lock"></i>
                            <span class="link-title">{{ trans('global.change_password') }}</span>
                        </a>
                    </li>

                @endcan
            @endif
            <li class="nav-item nav-category">Session</li>
            <li class="nav-item">
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="link-icon text-danger" data-feather="log-out"></i>
                    <span class="link-title text-danger">{{ trans('global.logout') }}</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
