@extends($activeTemplate.'layouts.frontend')

@section('content')
<div class="container py-80">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7 col-xl-5">
                <div class="card-body payment-info">
                    <form method="POST" action="{{ route('advertiser.data.submit') }}">
                        @csrf
                        <div class="row">
                            <div class="form-group col-sm-6 mb-3">
                                <input type="text" class="form--control" name="firstname"
                                    value="{{ old('firstname') }}" required>
                                <label class="form--label">@lang('First Name')</label>
                            </div>

                            <div class="form-group col-sm-6 mb-3">
                                <input type="text" class="form--control" name="lastname"
                                    value="{{ old('lastname') }}" required>
                                <label class="form--label">@lang('Last Name')</label>

                            </div>
                            <div class="form-group col-sm-6 mb-3">
                                <input type="text" class="form--control" name="address"
                                    value="{{ old('address') }}">
                                <label class="form--label">@lang('Address')</label>

                            </div>
                            <div class="form-group col-sm-6 mb-3">
                                <input type="text" class="form--control" name="state"
                                    value="{{ old('state') }}">
                                <label class="form--label">@lang('State')</label>

                            </div>
                            <div class="form-group col-sm-6 mb-3">
                                <input type="text" class="form--control" name="zip"
                                    value="{{ old('zip') }}">
                                <label class="form--label">@lang('Zip Code')</label>

                            </div>

                            <div class="form-group col-sm-6">
                                <input type="text" class="form--control" name="city"
                                    value="{{ old('city') }}">
                                <label class="form--label">@lang('City')</label>

                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn--base">
                                @lang('Save')
                            </button>
                        </div>
                    </form>
                </div>
        </div>
    </div>
</div>
@endsection
