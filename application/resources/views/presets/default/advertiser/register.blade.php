@extends($activeTemplate.'layouts.frontend')
@section('content')
@php
    $policyPages = getContent('policy_pages.element',false,null,true);
@endphp
<section class="signup-section pb-115">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-content">
                    <h2 class="section-title mb-2 wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">{{__($pageTitle)}}</h2>
                    <div class="title-btm-border mb-3 wow animate__animated animate__fadeInUp"  data-wow-delay="0.3s"></div>
                </div>
            </div>
        </div>
          <div class="row justify-content-center">
              <div class="col-lg-7 col-md-12">
                    <div class="log-in-box wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                        <!-- tab panel -->
                        <ul class="nav nav-tabs coustome-tabs" role="tablist">
                          <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab" aria-selected="false" tabindex="-1">@lang('Advertiser')</button>
                          </li>
                          <li class="nav-item" role="presentation">
                            <a href="{{route('register')}}" class="nav-link">@lang('Publisher')</a>
                          </li>
                        </ul>
                        <div class="tab-content">
                            {{-- publisher --}}
                            <div class="tab-pane fade active show" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                                <div class="sign-up_box wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                                    <h3 class="title wow animate__animated animate__fadeInUp text-center" data-wow-delay="0.3s">@lang('Please register with valid information')</h3>
                                    <form action="{{ route('advertiser.register') }}" method="POST" class="verify-gcaptcha">
                                        @csrf
                                        <div class="row wow animate__animated animate__fadeInUp" data-wow-delay="0.4s">
                                            <div class="col-xxl-6 col-lg-6 col-md-6 mb-3">
                                                <div class="form-group">
                                                    <input type="text" class="form--control checkAdvertiser" id="username" name="username" value="{{ old('username') }}" placeholder="" required>
                                                    <label class="form--label">@lang('Username')</label>
                                                </div>
                                                <small class="text-danger usernameadExist"></small>
                                            </div>
                                            <div class="col-xxl-6 col-lg-6 col-md-6 mb-3">
                                                <div class="form-group">
                                                    <input type="email" class="form--control checkAdvertiser" id="email" name="email" value="{{ old('email') }}" placeholder="" required>
                                                    <label class="form--label">@lang('EMail Address')</label>
                                                </div>

                                            </div>
                                        </div>


                                        <div class="row wow animate__animated animate__fadeInUp" data-wow-delay="0.6s">
                                            <div class="col-sm-6 mb-3">
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <select class="form-select form--control" name="country">
                                                            @foreach($countries as $key => $country)
                                                            <option data-mobile_code="{{ $country->dial_code }}" value="{{ $country->country }}" data-code="{{ $key }}">{{ __($country->country) }}</option>
                                                            @endforeach
                                                        </select>
                                                        <label class="form--label">@lang('Country')</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6 col-lg-6 col-md-6 mb-3">
                                                <div class="form-group">
                                                    <div class="input-group country-code">
                                                        <span class="input-group-text mobile-code"></span>
                                                        <input type="hidden" name="mobile_code">
                                                        <input type="hidden" name="country_code">
                                                        <input type="text" class="form--control checkAdvertiser"  name="mobile" value="{{ old('mobile') }}" placeholder="@lang('Mobile')">
                                                    </div>
                                                        <small class="text-danger mobileadExist"></small>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row wow animate__animated animate__fadeInUp" data-wow-delay="0.7s">
                                            <div class="col-sm-6 mb-3">
                                                <div class="form-group">
                                                    <input type="password" class="form--control" name="password" placeholder="" required>
                                                    <label class="form--label">@lang('Password')</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <div class="form-group">
                                                    <input class="form--control" type="password" name="password_confirmation" placeholder="" required>
                                                    <label class="form--label">@lang('Confirm Password')</label>
                                                </div>
                                            </div>
                                        </div>
                                        <x-captcha></x-captcha>
                                        @if($general->agree)
                                        <div class="mb-3 form--check wow animate__animated animate__fadeInUp" data-wow-delay="0.9s">
                                            <input class="form-check-input" type="checkbox" @checked(old('agree')) name="agree" required id="defaultCheck">
                                            <label class="form-check-label" for="defaultCheck">
                                                @lang('I agree with') @foreach($policyPages as $policy)
                                                <a href="{{ route('policy.pages',[slug($policy->data_values->title),$policy->id]) }}" class="text--base">{{ __($policy->data_values->title) }}
                                                </a>
                                                @endforeach
                                            </label>
                                        </div>
                                        @endif
                                          <button type="submit" class="btn btn--base wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">@lang('SignUp')</button>
                                          <p class="pt-3 wow animate__animated animate__fadeInUp" data-wow-delay="0.6s">@lang('Already have an account?') <a href="{{ route('advertiser.login') }}" class="text--base">@lang('Login')</a></p>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- tab panel -->
                    </div>
              </div>
          </div>
      </div>
</section>

<div class="modal fade" id="existModalCenter" tabindex="-1" role="dialog" aria-labelledby="existModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
          <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <i class="las la-times"></i>
          </span>
        </div>
        <div class="modal-body">
          <h6 class="text-center">@lang('You already have an account please Login ')</h6>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">@lang('Close')</button>
          <a href="{{ route('login') }}" class="btn btn--base btn-sm">@lang('Login')</a>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('style')
<style>
    .country-code select{
        border: none;
    }
    .country-code select:focus{
        border: none;
        outline: none;
    }
</style>
@endpush
@push('script-lib')
<script src="{{ asset('assets/common/js/secure_password.js') }}"></script>
@endpush
@push('script')
    <script>
      "use strict";
        (function ($) {
            @if($mobileCode)
            $(`option[data-code={{ $mobileCode }}]`).attr('selected','');
            @endif


        function updateMobileCode(selectedCountry) {
            const mobileCode = selectedCountry.data('mobile_code');
            $('input[name=mobile_code]').val(mobileCode);
            $('input[name=country_code]').val(selectedCountry.data('code'));
            $('.mobile-code').text('+' + mobileCode);
        }

        $('select[name=country]').change(function() {
            const selectedCountry = $(this).find(':selected');
            updateMobileCode(selectedCountry);
        });

        const initialActiveCountry = $('select[name=country] :selected');
        updateMobileCode(initialActiveCountry);


            @if($general->secure_password)
                $('input[name=password]').on('input',function(){
                    secure_password($(this));
                });

                $('[name=password]').focus(function () {
                    $(this).closest('.form-group').addClass('hover-input-popup');
                });

                $('[name=password]').focusout(function () {
                    $(this).closest('.form-group').removeClass('hover-input-popup');
                });

            @endif

            $('.checkPublisher').on('focusout',function(e){
                var url = '{{ route('publisher.checkPublisher') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {mobile:mobile,_token:token}
                }
                if ($(this).attr('name') == 'email') {
                    var data = {email:value,_token:token}
                }
                if ($(this).attr('name') == 'username') {
                    var data = {username:value,_token:token}
                }
                $.post(url,data,function(response) {
                  if (response.data != false && response.type == 'email') {
                    $('#existModalCenter').modal('show');
                  }else if(response.data != false){

                    $(`.${response.type}Exist`).text(`${response.type} already exist`);
                  }else{
                    $(`.${response.type}Exist`).text('');
                  }
                });
            });


            // advertiser
            $('.checkAdvertiser').on('focusout',function(e){
                var url = '{{ route('advertiser.checkAdvertiser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {mobile:mobile,_token:token}
                }
                if ($(this).attr('name') == 'email') {
                    var data = {email:value,_token:token}
                }
                if ($(this).attr('name') == 'username') {
                    var data = {username:value,_token:token}
                }
                $.post(url,data,function(response) {
                  if (response.data != false && response.type == 'email') {
                    $('#existModalCenter').modal('show');
                  }else if(response.data != false){

                    $(`.${response.type}adExist`).text(`${response.type} already exist`);
                  }else{
                    $(`.${response.type}adExist`).text('');
                  }
                });
            });

        })(jQuery);

    </script>
@endpush
