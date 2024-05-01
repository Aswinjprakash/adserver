<div class="row">
    <div class="col">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.publishers.active') ? 'active' : '' }}"
                    href="{{route('admin.publishers.active')}}">@lang('Active')</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.publishers.banned') ? 'active' : '' }}"
                    href="{{route('admin.publishers.banned')}}">@lang('Banned')
                    @if($publisherBannedUsersCount)
                    <span class="badge rounded-pill bg--white text-muted">{{$publisherBannedUsersCount}}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.publishers.email.unverified') ? 'active' : '' }}"
                    href="{{route('admin.publishers.email.unverified')}}">@lang('Email Unverified')
                    @if($publisherMailUnverifiedUsersCount)
                    <span class="badge rounded-pill bg--white text-muted">{{$publisherMailUnverifiedUsersCount}}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.publishers.mobile.unverified') ? 'active' : '' }}"
                    href="{{route('admin.publishers.mobile.unverified')}}">@lang('Mobile Unverified')
                    @if($publisherMobileUnverifiedUsersCount)
                    <span class="badge rounded-pill bg--white text-muted">{{$publisherMobileUnverifiedUsersCount}}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.publishers.with.balance') ? 'active' : '' }}"
                    href="{{route('admin.publishers.with.balance')}}">@lang('With Balance')
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.publishers.all') ? 'active' : '' }}"
                    href="{{route('admin.publishers.all')}}">@lang('All Users')
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.publishers.notification.all') ? 'active' : '' }}"
                    href="{{route('admin.publishers.notification.all')}}">@lang('Notification to Users')
                </a>
            </li>
        </ul>
    </div>
</div>
