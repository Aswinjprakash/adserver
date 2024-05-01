 @php
 $user = auth()->guard('publisher')->user();
 @endphp
 <!-- < dashboard side bar -->
 <div class="col-xxl-2 col-xl-3 col-lg-4">
    <div class="dashboard_profile">
        <div class="dashboard_profile__details">
            <div class="sidebar-menu">
                <span class="sidebar-menu__close"><i class="las la-times"></i></span>
                <div class="dashboard_profile_wrap">
                    <div class="profile_photo">
                        <form action="{{ route('publisher.profile.image.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                        <img src="{{ getImage(getFilePath('userProfile').'/'.@$user->image,getFileSize('userProfile')) }}" alt="{{__(@$user->username)}}">
                        <div class="photo_upload">
                            <label for="image"><i class="fas fa-image"></i></label>
                            <input id="image" name="image" type="file" class="upload_file" onchange="this.form.submit()">
                        </div>
                        </form>
                    </div>
                    <h3 class="text-center">@ {{__($user->username)}}</h3>
                </div>
                <ul class="sidebar-menu-list">
                    <li class="sidebar-menu-list__item {{ Route::is('publisher.home') ? 'active' : '' }}">
                        <a href="{{route('publisher.home')}}" class="sidebar-menu-list__link">
                        <span class="icon"><i class="fa fa-tachometer-alt"></i></span>
                        <span class="text">@lang('Dashboard')</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-list__item {{ Route::is('publisher.domain.index') ? 'active' : '' }}">
                        <a href="{{route('publisher.domain.index')}}" class="sidebar-menu-list__link">
                        <span class="icon"><i class="fas fa-check-circle"></i></span>
                        <span class="text">@lang('Domain')</span>
                        </a>
                    </li>
                     <li class="sidebar-menu-list__item {{ Route::is('publisher.advertises') ? 'active' : '' }}">
                        <a href="{{route('publisher.advertises')}}" class="sidebar-menu-list__link">
                        <span class="icon"><i class="fas fa-ad"></i></span>
                        <span class="text">@lang('Advertisements')</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-list__item {{ Route::is('publisher.published.ad') ? 'active' : '' }}">
                        <a href="{{route('publisher.published.ad')}}" class="sidebar-menu-list__link">
                        <span class="icon"><i class="fab fa-adn"></i></span>
                        <span class="text">@lang('Published Ads')</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-list__item {{ Route::is('publisher.published.perday.ad') ? 'active' : '' }}">
                        <a href="{{route('publisher.published.perday.ad')}}" class="sidebar-menu-list__link">
                        <span class="icon"><i class="far fa-list-alt"></i></span>
                        <span class="text">@lang('Per Day Ads Report')</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-list__item {{ Route::is('publisher.published.perday.earning') ? 'active' : '' }}">
                        <a href="{{route('publisher.published.perday.earning')}}" class="sidebar-menu-list__link">
                        <span class="icon"><i class="fas fa-hand-holding-usd"></i></span>
                        <span class="text">@lang('Per Day Earning Report')</span>
                        </a>
                    </li>


                    <li class="sidebar-menu-list__item has-dropdown">
                        <a href="javascript:void(0)" class="sidebar-menu-list__link">
                        <span class="icon"><i class="fas fa-dollar-sign"></i></span>
                        <span class="text">@lang('Withdraw')</span>
                        </a>
                        <div class="sidebar-submenu">
                            <ul class="sidebar-submenu-list">
                                <li class="sidebar-submenu-list__item {{ Route::is('user.withdraw') ? 'active' : '' }}">
                                    <a href="{{route('user.withdraw')}}" class="sidebar-submenu-list__link">@lang('Withdraw')</a>
                                </li>
                                <li class="sidebar-submenu-list__item {{ Route::is('user.withdraw.history') ? 'active' : '' }}">
                                    <a href="{{route('user.withdraw.history')}}" class="sidebar-submenu-list__link">@lang('Withdraw Log')</a>
                                </li>

                            </ul>
                        </div>
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
                    <li class="sidebar-menu-list__item {{ Route::is('publisher.transactions') ? 'active' : '' }}">
                        <a href="{{route('publisher.transactions')}}" class="sidebar-menu-list__link">
                        <span class="icon"><i class="fas fa-funnel-dollar"></i></span>
                        <span class="text">@lang('Transaction log')</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-list__item has-dropdown">
                        <a href="javascript:void(0)" class="sidebar-menu-list__link">
                        <span class="icon"><i class="fa fa-user"></i></span>
                        <span class="text">@lang('Profile')</span>
                        </a>
                        <div class="sidebar-submenu">
                            <ul class="sidebar-submenu-list">
                                <li class="sidebar-submenu-list__item {{ Route::is('publisher.profile.setting') ? 'active' : '' }}">
                                    <a href="{{ route('publisher.profile.setting') }}" class="sidebar-submenu-list__link">@lang('Profile Setting')</a>
                                </li>
                                <li class="sidebar-submenu-list__item {{ Route::is('publisher.change.password') ? 'active' : '' }}">
                                    <a href="{{route('publisher.change.password')}}" class="sidebar-submenu-list__link">@lang('Change Password')</a>
                                </li>
                                <li class="sidebar-submenu-list__item {{ Route::is('publisher.twofactor') ? 'active' : '' }}">
                                    <a href="{{ route('publisher.twofactor') }}" class="sidebar-submenu-list__link">@lang('Google Authentication')</a>
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
