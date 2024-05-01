 @php
 $user = auth()->guard('advertiser')->user();
 @endphp
 <!-- < dashboard side bar -->
 <div class="col-xxl-2 col-xl-3 col-lg-4">
    <div class="dashboard_profile">
        <div class="dashboard_profile__details">
            <div class="sidebar-menu">
                <span class="sidebar-menu__close"><i class="las la-times"></i></span>
                <div class="dashboard_profile_wrap">
                    <div class="profile_photo">
                        <form action="{{ route('advertiser.profile.image.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                        <img src="{{ getImage(getFilePath('userProfile').'/'.$user->image,getFileSize('userProfile')) }}" alt="{{__(@$user->username)}}">
                        <div class="photo_upload">
                            <label for="image"><i class="fas fa-image"></i></label>
                            <input id="image" name="image" type="file" class="upload_file" onchange="this.form.submit()">
                        </div>
                        </form>
                    </div>
                    <h3 class="text-center">@ {{__($user->username)}}</h3>
                </div>
                <ul class="sidebar-menu-list">
                    <li class="sidebar-menu-list__item {{ Route::is('advertiser.home') ? 'active' : '' }}">
                        <a href="{{route('advertiser.home')}}" class="sidebar-menu-list__link">
                        <span class="icon"><i class="fa fa-tachometer-alt"></i></span>
                        <span class="text">@lang('Dashboard')</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-list__item has-dropdown">
                        <a href="javascript:void(0)" class="sidebar-menu-list__link">
                        <span class="icon"><i class="fas fa-ad"></i></span>
                        <span class="text">@lang('Ads Management')</span>
                        </a>
                        <div class="sidebar-submenu">
                            <ul class="sidebar-submenu-list">
                                <li class="sidebar-submenu-list__item {{ Route::is('advertiser.ad.index') ? 'active' : '' }}">
                                    <a href="{{ route('advertiser.ad.index') }}" class="sidebar-submenu-list__link">@lang('All Ads')</a>
                                </li>
                                <li class="sidebar-submenu-list__item {{ Route::is('advertiser.ad.types') ? 'active' : '' }}">
                                    <a href="{{ route('advertiser.ad.types') }}" class="sidebar-submenu-list__link">@lang('Create Ad')</a>
                                </li>
                                <li class="sidebar-submenu-list__item {{ Route::is('advertiser.ad.report') ? 'active' : '' }}">
                                    <a href="{{ route('advertiser.ad.report') }}" class="sidebar-submenu-list__link">@lang('Ads Report')</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="sidebar-menu-list__item {{ Route::is('advertiser.get.plan') ? 'active' : '' }}">
                        <a href="{{route('advertiser.get.plan')}}" class="sidebar-menu-list__link">
                        <span class="icon"><i class="fas fa-gift"></i></span>
                        <span class="text">@lang('Plans')</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-list__item {{ Route::is('advertiser.perday.report') ? 'active' : '' }}">
                        <a href="{{route('advertiser.perday.report')}}" class="sidebar-menu-list__link">
                        <span class="icon"><i class="far fa-list-alt"></i></span>
                        <span class="text">@lang('Per Day Logs')</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-list__item has-dropdown">
                        <a href="javascript:void(0)" class="sidebar-menu-list__link">
                        <span class="icon"><i class="fas fa-headset"></i></span>
                        <span class="text">@lang('Support Tickets')</span>
                        </a>
                        <div class="sidebar-submenu">
                            <ul class="sidebar-submenu-list">
                                <li class="sidebar-submenu-list__item {{ Route::is('ticket') ? 'active' : '' }}">
                                    <a href="{{ route('ticket') }}" class="sidebar-submenu-list__link">@lang('My Tickets')</a>
                                </li>
                                <li class="sidebar-submenu-list__item {{ Route::is('ticket.open') ? 'active' : '' }}">
                                    <a href="{{ route('ticket.open') }}" class="sidebar-submenu-list__link">@lang('New Ticket')</a>
                                </li>

                            </ul>
                        </div>
                    </li>
                    <li class="sidebar-menu-list__item {{ Route::is('advertiser.transactions') ? 'active' : '' }}">
                        <a href="{{route('advertiser.transactions')}}" class="sidebar-menu-list__link">
                        <span class="icon"><i class="fas fa-search-dollar"></i></span>
                        <span class="text">@lang('Transaction log')</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-list__item has-dropdown">
                        <a href="javascript:void(0)" class="sidebar-menu-list__link">
                        <span class="icon"><i class="fas fa-dollar-sign"></i></span>
                        <span class="text">@lang('Deposit')</span>
                        </a>
                        <div class="sidebar-submenu">
                            <ul class="sidebar-submenu-list">
                                <li class="sidebar-submenu-list__item {{ Route::is('user.deposit') ? 'active' : '' }}">
                                    <a href="{{ route('user.deposit') }}" class="sidebar-submenu-list__link">@lang('Deposit')</a>
                                </li>
                                <li class="sidebar-submenu-list__item {{ Route::is('advertiser.deposit.history') ? 'active' : '' }}">
                                    <a href="{{ route('advertiser.deposit.history') }}" class="sidebar-submenu-list__link">@lang('Deposit Log')</a>
                                </li>

                            </ul>
                        </div>
                    </li>
                    <li class="sidebar-menu-list__item has-dropdown">
                        <a href="javascript:void(0)" class="sidebar-menu-list__link">
                        <span class="icon"><i class="fa fa-user"></i></span>
                        <span class="text">@lang('Profile')</span>
                        </a>
                        <div class="sidebar-submenu">
                            <ul class="sidebar-submenu-list">
                                <li class="sidebar-submenu-list__item {{ Route::is('advertiser.profile.setting') ? 'active' : '' }}">
                                    <a href="{{ route('advertiser.profile.setting') }}" class="sidebar-submenu-list__link">@lang('Profile Setting')</a>
                                </li>
                                <li class="sidebar-submenu-list__item {{ Route::is('advertiser.change.password') ? 'active' : '' }}">
                                    <a href="{{route('advertiser.change.password')}}" class="sidebar-submenu-list__link">@lang('Change Password')</a>
                                </li>
                                <li class="sidebar-submenu-list__item {{ Route::is('advertiser.twofactor') ? 'active' : '' }}">
                                    <a href="{{ route('advertiser.twofactor') }}" class="sidebar-submenu-list__link">@lang('Google Authentication')</a>
                                </li>

                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- dashboard side bar /> -->
