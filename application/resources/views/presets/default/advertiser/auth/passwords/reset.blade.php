@extends($activeTemplate.'layouts.frontend')
@section('content')
<div class="container py-80">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7 col-xl-5">

            <h5 class="card-title">@lang('Reset Password')</h5>

            <div class="mb-4">
                <p>@lang('Your account is verified successfully. Now you can change your password. Please enter
                    a strong password and don\'t share it with anyone.')</p>
            </div>
            <form method="POST" action="{{ route('advertiser.password.update') }}">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group">
                    <input type="password" class="form--control" name="password" required>
                    <label class="form--label">@lang('Password')</label>
                    @if($general->secure_password)
                    <div class="input-popup">
                        <p class="error lower">@lang('1 small letter minimum')</p>
                        <p class="error capital">@lang('1 capital letter minimum')</p>
                        <p class="error number">@lang('1 number minimum')</p>
                        <p class="error special">@lang('1 special character minimum')</p>
                        <p class="error minimum">@lang('6 character password')</p>
                    </div>
                    @endif
                </div>
                <div class="form-group mb-3">
                    <input type="password" class="form--control" name="password_confirmation"
                        required>
                    <label class="form--label">@lang('Confirm Password')</label>

                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn--base"> @lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script-lib')
<script src="{{ asset('assets/common/js/secure_password.js') }}"></script>
@endpush
@push('script')
<script>
    (function ($) {
        "use strict";
        @if ($general -> secure_password)
            $('input[name=password]').on('input', function () {
                secure_password($(this));
            });

        $('[name=password]').focus(function () {
            $(this).closest('.form-group').addClass('hover-input-popup');
        });

        $('[name=password]').focusout(function () {
            $(this).closest('.form-group').removeClass('hover-input-popup');
        });
        @endif
    })(jQuery);
</script>
@endpush
