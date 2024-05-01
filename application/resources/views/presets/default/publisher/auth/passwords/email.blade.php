@extends($activeTemplate.'layouts.frontend')
@section('content')
<div class="container py-80">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7 col-xl-5 payment-info">
            <h5 class="card-title">{{ __($pageTitle) }}</h5>
            <div class="mb-4">
                <p>@lang('To recover your account please provide your email or username to find your account.')
                </p>
            </div>
            <form method="POST" action="{{ route('publisher.password.email') }}">
                @csrf
                <div class="form-group mb-3">
                    <input type="text" class="form--control" name="value"
                        value="{{ old('value') }}" required autofocus="off">
                    <label class="form--label">@lang('Email or Username')</label>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn--base">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
