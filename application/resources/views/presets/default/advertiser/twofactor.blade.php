@extends($activeTemplate.'layouts.advertiser.master')
@section('content')
<div class="row gy-4 justify-content-center">
    @if (!auth()->guard('advertiser')->user()->ts)
    <div class="col-xl-7 col-lg-7">
        <div class="payment-info">
            <div class="form-group mx-auto text-center">
                <img class="mx-auto" src="{{ $qrCodeUrl }}" alt="qr-img">
            </div>

            <div class="form-group mb-3">
                <label class="form-label" for="key">@lang('Setup Key')</label>
                <div class="input-group">
                    <input type="text"  name="key" value="{{ $secret }}" class="form-control form--control referralURL" readonly>
                    <button type="button" class="input-group-text copytext" id="copyBoard" style="border-radius: 0px;"> <i class="fa fa-copy"></i> </button>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="col-xl-5 col-lg-5">
        @if (auth()->guard('advertiser')->user()->ts)
        <div class="payment-info">
        <h5>@lang('Disable 2FA Security')</h5>
            <form action="{{ route('advertiser.twofactor.disable') }}" method="POST">
                @csrf
                <input type="hidden" name="key" value="{{ $secret }}">
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label class="form-label required" for="code">@lang('Google Authenticatior OTP')</label>
                        <input type="text" class="form--control" name="code" required>
                    </div>
                    <button type="submit" class="btn btn--base">@lang('Submit')</button>
                </div>
            </form>
        </div>
        @else
        <div class="payment-info">
            <h5>@lang('Enable 2FA Security')</h5>
            <form action="{{ route('advertiser.twofactor.enable') }}" method="POST">
                @csrf
                <input type="hidden" name="key" value="{{ $secret }}">
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label class="form-label required" for="code">@lang('Google Authenticatior OTP')</label>
                        <input type="text" class="form--control" name="code" required>
                    </div>
                    <button type="submit" class="btn btn--base">@lang('Submit')</button>
                </div>
            </form>
        </div>
        @endif
    </div>
</div>


@endsection

@push('style')
<style>
    .copied::after {
        background-color: #{{ $general->base_color }
    }

    ;
    }
</style>
@endpush

@push('script')
<script>
    (function ($) {
        "use strict";
        $('#copyBoard').on('click', function () {
            var copyText = document.getElementsByClassName("referralURL");
            copyText = copyText[0];
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            /*For mobile devices*/
            document.execCommand("copy");
            copyText.blur();
            this.classList.add('copied');
            setTimeout(() => this.classList.remove('copied'), 1500);
        });
    })(jQuery);
</script>
@endpush
