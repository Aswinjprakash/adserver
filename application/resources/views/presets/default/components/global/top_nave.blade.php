

        <!-- < dashboard header -->
        <div class="row my-4">
            <div class="col-lg-12">
                <div class="dashboard-header">
                    <div class="dashboard-body__bar">
                        <span class="dashboard-body__bar-icon"><i class="las la-bars"></i></span>
                    </div>
                    <div class="search-box">
                        <h4>{{__($pageTitle)}}</h4>
                    </div>
                    <ul>
                        <li><a href="{{route('home')}}"><i class="fas fa-globe" title="@lang('Home')"></i></a></li>
                        @if(auth()->guard('advertiser')->user())
                        <li><a href="{{route('advertiser.logout')}}" title="@lang('Logout')"><i class="fas fa-sign-out-alt"></i></a></li>
                        @endif
                        @if(auth()->guard('publisher')->user())
                        <li><a href="{{route('publisher.logout')}}" title="@lang('Logout')"><i class="fas fa-sign-out-alt"></i></a></li>
                        @endif
                        <li>
                            <div class="light-dark-btn-wrap" id="light-dark-checkbox">
                              <i class="fas fa-moon mon-icon"></i>
                              <i class='fas fa-sun sun-icon'></i>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
