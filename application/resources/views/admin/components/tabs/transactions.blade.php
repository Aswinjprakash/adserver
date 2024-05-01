<div class="row">
    <div class="col">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.report.transaction') ? 'active' : '' }}"
                    href="{{route('admin.report.transaction')}}">@lang('Advertiser')</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.report.publisher.transaction') ? 'active' : '' }}"
                    href="{{route('admin.report.publisher.transaction')}}">@lang('Publisher')
                </a>
            </li>

        </ul>
    </div>
</div>
