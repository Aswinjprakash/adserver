<div class="row">
    <div class="col">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.report.login.history') ? 'active' : '' }}"
                    href="{{route('admin.report.login.history')}}">@lang('Advertiser')</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.report.publisher.login.history') ? 'active' : '' }}"
                    href="{{route('admin.report.publisher.login.history')}}">@lang('Publisher')
                </a>
            </li>

        </ul>
    </div>
</div>
