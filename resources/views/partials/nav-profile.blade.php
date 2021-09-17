<li class="nav-item dropdown nav-profile">
    <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        @if (auth()->user()->profile)
            <img src="{{auth()->user()->profile->thumbnail}}" alt="profile">
        @else
            <img src="https://via.placeholder.com/30x30" alt="profile">
        @endif
    </a>
    <div class="dropdown-menu" aria-labelledby="profileDropdown">
        <div class="dropdown-header d-flex flex-column align-items-center">
            <div class="figure mb-3">
                @if (auth()->user()->profile)
                    <img src="{{auth()->user()->profile->thumbnail}}" alt="profile">
                @else
                    <img src="https://via.placeholder.com/80x80" alt="profile">
                @endif
            </div>
            <div class="info text-center">
                <p class="name font-weight-bold mb-0">{{ auth()->user()->name ? auth()->user()->name : '' }}</p>
                <p class="email text-muted mb-3">{{ auth()->user()->email ? auth()->user()->email : '' }}</p>
            </div>
        </div>
        <div class="dropdown-body">
            <ul class="profile-nav p-0 pt-3">
                <li class="nav-item">
                    <a href="{{ route('profile.password.edit') }}" class="nav-link">
                        <i data-feather="user"></i>
                        <span>{{ trans('global.my_profile') }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                        <i data-feather="log-out"></i>
                        <span>{{ trans('global.logout') }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</li>
