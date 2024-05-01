@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="login-section pb-115">
        <div class="container">
            <div class="row mb-80">
                <div class="col-lg-12">
                    <div class="section-content">
                        <h2 class="section-title mb-2 wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                            {{ __($pageTitle) }}</h2>
                        <div class="title-btm-border mb-3 wow animate__animated animate__fadeInUp" data-wow-delay="0.3s">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-7">
                    <div class="log-in-box wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                        <!-- tab panel -->
                        <ul class="nav nav-tabs coustome-tabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic"
                                    type="button" role="tab" aria-selected="false"
                                    tabindex="-1">@lang('Advertiser')</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="{{route('login')}}" class="nav-link">@lang('Publisher')</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            {{-- advertiser --}}
                            <div class="tab-pane fade active show" id="basic" role="tabpanel"
                                aria-labelledby="basic-tab">
                                <div class="row justify-content-center">
                                    <div
                                        class="col-xl-12 col-md-12 d-flex align-content-center flex-column justify-content-center">
                                        <div class="login wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                                            <h2 class="welcome-text text-center">@lang('Welcome to') {{ __($general->site_name) }}</h2>
                                            <form method="POST" action="{{route('advertiser.login')}}" class="verify-gcaptcha">
                                                @csrf
                                                <div class="form-group pwow animate__animated animate__fadeInUp"
                                                    data-wow-delay="0.3s">
                                                    <input type="text" class="form--control mb-3" autocomplete="off"
                                                        id="username" name="username" value="{{ old('username') }}"
                                                        required placeholder=" ">
                                                    <label class="form--label">@lang('Username or Email')</label>
                                                </div>
                                                <div class="form-group wow animate__animated animate__fadeInUp"
                                                    data-wow-delay="0.3s">
                                                    <input type="password"
                                                        class="form--control mb-3 wow animate__animated animate__fadeInUp"
                                                        name="password" id="your-password" autocomplete="off"
                                                        placeholder=" " data-wow-delay="0.4s">
                                                    <label class="form--label">@lang('Password')</label>
                                                </div>
                                                <x-captcha></x-captcha>
                                                <div class="login-meta mb-3 wow animate__animated animate__fadeInUp"
                                                    data-wow-delay="0.5s">
                                                    <div class="form--check">
                                                        <input class="form-check-input" type="checkbox" name="remember"
                                                            id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                        <label class="form-check-label">@lang('Remember me')</label>
                                                    </div>
                                                    <a href="{{ route('advertiser.password.request') }}">@lang('Forgot Your Password?')</a>
                                                </div>
                                                <button class="btn btn--base wow animate__animated animate__fadeInUp"
                                                    type="submit" id="recaptcha"
                                                    data-wow-delay="0.5s">@lang('Login')</button>
                                            </form>
                                            <p class="pt-3 wow animate__animated animate__fadeInUp" data-wow-delay="0.6s">
                                                @lang('Don\'t have any account?') <a href="{{ route('advertiser.register') }}" class="text--base">
                                                    @lang('Create Account')</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- tab panel -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
