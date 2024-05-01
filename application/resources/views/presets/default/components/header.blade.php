@php
    $languages = App\Models\Language::all();
    $pages = App\Models\Page::where('tempname', $activeTemplate)->get();
@endphp
<!--========================== Header section Start ==========================-->
<div class="header-main-area">
    <div class="header" id="header">
      <div class="container position-relative">
        <div class="row">
            <div class="header-wrapper">
              <!-- ham menu -->
              <i class="fas fa-bars ham__menu" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasExample" aria-controls="offcanvasExample"></i>

              <!-- logo -->
              <div class="header-menu-wrapper align-items-center d-flex">
                <div class="logo-wrapper">
                    <a href="{{ route('home') }}" class="normal-logo"> <img
                            src="{{ getImage(getFilePath('logoIcon') . '/logo.png', '?' . time()) }}"
                            alt="{{ config('app.name') }}"></a>

                    <a href="{{ route('home') }}" class="dark-logo hidden"> <img
                            src="{{ getImage(getFilePath('logoIcon') . '/logo_white.png', '?' . time()) }}"
                            alt="{{ config('app.name') }}"></a>
                </div>
              </div>
              <!-- / logo -->

              <div class="menu-wrapper">
                <ul class="main-menu">

                    @foreach ($pages as $page)
                    <li>
                        <a class="{{ request()->url() === route('pages', [$page->slug]) ? 'active' : '' }}"
                            aria-current="page"
                            href="{{ route('pages', [$page->slug]) }}">{{ __($page->name) }}
                        </a>
                    </li>
                @endforeach

                </ul>
              </div>

                <div class="menu-right-wrapper">
                  <ul>

                    @if(auth()->guard('publisher')->user())
                        <li class="login-registration-list__item">
                            <span class="login-registration-list__icon">
                                <i class="fa fa-tachometer-alt"></i>
                            </span>
                            <a href="{{ route('publisher.home') }}" class="login-registration-list__link">@lang('Dashboard')</a>
                        </li>
                    @elseif(auth()->guard('advertiser')->user())
                        <li class="login-registration-list__item">
                            <span class="login-registration-list__icon">
                                <i class="fa fa-tachometer-alt"></i>
                            </span>
                            <a href="{{ route('advertiser.home') }}" class="login-registration-list__link">@lang('Dashboard')</a>
                        </li>
                    @else
                    <li class="login-registration-list__item">
                        <span class="login-registration-list__icon">
                        <i class="fas fa-sign-in-alt"></i>
                        </span>
                        <a href="{{ route('login') }}" class="login-registration-list__link">@lang('Login')</a>
                    </li>
                    @endif

                    <li class="language-box">
                        <i class="fas fa-globe"></i>
                        <select class="langSel select">
                            @foreach ($languages as $language)
                                <option value="{{ $language->code }}"
                                    @if (Session::get('lang') === $language->code) selected @endif>{{ __($language->name) }}
                                </option>
                            @endforeach
                    </select>
                    </li>

                    <li>
                      <div class="light-dark-btn-wrap ms-1" id="light-dark-checkbox">
                        <i class="fas fa-moon mon-icon"></i>
                        <i class='fas fa-sun sun-icon'></i>
                      </div>
                    </li>

                  </ul>
                </div>
            </div>
        </div>
      </div>
    </div>
</div>
  <!--========================== Header section End ==========================-->

  <!--========================== Sidebar mobile menu wrap Start ==========================-->
<div class="offcanvas offcanvas-start text-bg-light" tabindex="-1" id="offcanvasExample">
<div class="offcanvas-header">
    <div class="logo">
    <div class="header-menu-wrapper align-items-center d-flex">
        <div class="logo-wrapper">
            <a href="{{ route('home') }}" class="normal-logo"> <img
                    src="{{ getImage(getFilePath('logoIcon') . '/logo.png', '?' . time()) }}"
                    alt="{{ config('app.name') }}">
                </a>

            <a href="{{ route('home') }}" class="dark-logo hidden"> <img
                    src="{{ getImage(getFilePath('logoIcon') . '/logo_white.png', '?' . time()) }}"
                alt="{{ config('app.name') }}">
            </a>
        </div>
    </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>
<div class="offcanvas-body">
    @if(auth()->guard('publisher')->user())
        <div class="user-info"
            style="background: url({{ asset($activeTemplateTrue . 'images/sidenav_user.jpg') }});background-position: center;background-size: cover; filter: grayscale(30%) ;">
            <div class="user-thumb">
                <img src="{{ getImage(getFilePath('userProfile') . '/' . auth()->guard('publisher')->user()->image, getFileSize('userProfile')) }}"
                    alt="user-image">
            </div>
            <h4 class="text-white">{{ __(auth()->guard('publisher')->user()->fullname) }}</h4>
        </div>
    @endif

    @if(auth()->guard('advertiser')->user())
        <div class="user-info"
            style="background: url({{ asset($activeTemplateTrue . 'images/sidenav_user.jpg') }});background-position: center;background-size: cover; filter: grayscale(30%) ;">
            <div class="user-thumb">
                <img src="{{ getImage(getFilePath('userProfile') . '/' . auth()->guard('advertiser')->user()->image, getFileSize('userProfile')) }}"
                    alt="user-image">
            </div>
            <h4 class="text-white">{{ __(auth()->guard('advertiser')->user()->fullname) }}</h4>
        </div>
    @endif


    <ul class="side-Nav">
        @if(auth()->guard('publisher')->user())
            <li>
                <a href="{{ route('publisher.home') }}" class="{{ Route::is('publisher.home') ? 'active' : '' }}">@lang('Dashboard')</a>
            </li>
        @endif
        @if(auth()->guard('advertiser')->user())
            <li>
                <a href="{{ route('advertiser.home') }}" class="{{ Route::is('advertiser.home') ? 'active' : '' }}">@lang('Dashboard')</a>
            </li>
        @endif
        @foreach ($pages as $page)
            <li>
                <a href="{{ route('pages', [$page->slug]) }}" class="{{ request()->url() === route('pages', [$page->slug]) ? 'active' : '' }}"> {{ __($page->name) }}</a>
            </li>
        @endforeach
        @if(auth()->guard('advertiser')->user())
            <li>
                <a href="{{ route('advertiser.logout') }}">@lang('Logout')</a>
            </li>
        @endif
        @if(auth()->guard('publisher')->user())
            <li>
                <a href="{{ route('publisher.logout') }}">@lang('Logout')</a>
            </li>
        @endif
        @if(!auth()->guard('publisher')->user() && !auth()->guard('advertiser')->user())
            <li>
                <a href="{{ route('login') }}"  class="{{ Route::is('login') ? 'active' : '' }}">@lang('Login')</a>
            </li>
            <li>
                <a href="{{ route('register') }}" class="{{ Route::is('register') ? 'active' : '' }}">@lang('Register')</a>
            </li>
        @endauth
    </ul>
</div>
</div>
  <!--========================== Sidebar mobile menu wrap End ==========================-->
