<div class="row">
    <div class="col">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.report.advertiser.notification.history') ? 'active' : '' }}"
                    href="{{route('admin.report.advertiser.notification.history')}}">@lang('Advertiser')</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.report.publisher.notification.history') ? 'active' : '' }}"
                    href="{{route('admin.report.publisher.notification.history')}}">@lang('Publisher')
                </a>
            </li>

        </ul>
    </div>
</div>
