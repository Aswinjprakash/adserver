@extends($activeTemplate .'layouts.frontend')
@section('content')
<div class="container py-80">
    <div class="d-flex justify-content-center">
        <div class="verification-code-wrapper">
            <div class="verification-area">
                <h5 class="pb-3 text-center border-bottom">@lang('Verify Mobile Number')</h5>
                <form action="{{route('verify.mobile',$guard)}}" method="POST" class="submit-form">
                    @csrf
                    <p class="verification-text">@lang('A 6 digit verification code sent to your mobile number') : +{{
                        showMobileNumber(auth()->guard($guard)->user()->mobile) }}</p>
                    @include($activeTemplate.'components.verification_code')
                    <div class="mb-3">
                        <button type="submit" class="btn btn--base">@lang('Submit')</button>
                    </div>
                    <div class="form-group">
                        <p>
                            @lang('If you don\'t get any code'), <a href="{{route('send.verify.code',['phone',$guard])}}"
                                class="forget-pass"> @lang('Try again')</a>
                        </p>
                        @if($errors->has('resend'))
                        <br />
                        <small class="text-danger">{{ $errors->first('resend') }}</small>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
