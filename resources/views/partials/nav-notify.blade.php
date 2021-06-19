<li class="nav-item dropdown nav-notifications">
    <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i data-feather="bell"></i>
        @php($alertsCount = \Auth::user()->userUserAlerts()->where('read', false)->count())
        @if($alertsCount > 0)
        <div class="indicator">
            <div class="circle"></div>
        </div>
        @endif
    </a>
    <div class="dropdown-menu" aria-labelledby="notificationDropdown">
        <div class="dropdown-header d-flex align-items-center justify-content-between">
            <p class="mb-0 font-weight-medium">6 New Notifications</p>
            <a href="javascript:;" class="text-muted">Clear all</a>
        </div>
        <div class="dropdown-body">
            <a href="javascript:;" class="dropdown-item">
                <div class="icon">
                    <i data-feather="user-plus"></i>
                </div>
                <div class="content">
                    <p>New customer registered</p>
                    <p class="sub-text text-muted">2 sec ago</p>
                </div>
            </a>
            @php($alertsCount = \Auth::user()->userUserAlerts()->where('read', false)->count())
            @if($alertsCount > 0)
            <a href="{{ route('admin.alert.read') }}" class="dropdown-item">
                <div class="icon">
                    <i data-feather="alert-octagon"></i>
                </div>
                <div class="content">
                    <p>New user alert</p>
                    <p class="sub-text text-muted">{{ $alertsCount }} alert{{ $alertsCount > 1 ? 's' : ''}}</p>
                </div>
            </a>
            @else
            <a href="javascript:;" class="dropdown-item">
                <div class="icon">
                    <i data-feather="alert-octagon"></i>
                </div>
                <div class="content">
                    <p>{{ trans('global.no_user_alerts') }}</p>
                </div>
            </a>
            @endif
            <a href="javascript:;" class="dropdown-item">
                <div class="icon">
                    <i data-feather="gift"></i>
                </div>
                <div class="content">
                    <p>New Order Recieved</p>
                    <p class="sub-text text-muted">30 min ago</p>
                </div>
            </a>
            <a href="javascript:;" class="dropdown-item">
                <div class="icon">
                    <i data-feather="layers"></i>
                </div>
                <div class="content">
                    <p>Apps are ready for update</p>
                    <p class="sub-text text-muted">5 hrs ago</p>
                </div>
            </a>
            <a href="javascript:;" class="dropdown-item">
                <div class="icon">
                    <i data-feather="download"></i>
                </div>
                <div class="content">
                    <p>Download completed</p>
                    <p class="sub-text text-muted">6 hrs ago</p>
                </div>
            </a>
        </div>
        <div class="dropdown-footer d-flex align-items-center justify-content-center">
            <a href="javascript:;">View all</a>
        </div>
    </div>
</li>
