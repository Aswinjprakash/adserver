@extends($activeTemplate.'layouts.publisher.master')
@section('content')
<div class="row gy-4 justify-content-center">
    <div class="col-lg-8 justify-content-center">
        <div class="user-profile payment-info">
            <form class="register" action="" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row gy-3">
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <input type="text" class="form--control" id="firstname" name="firstname"
                            value="{{$user->firstname}}" placeholder="" required>
                            <label for="firstname" class="form--label required"> @lang('First Name')</label>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <input type="text" class="form--control" id="lastname" name="lastname"
                            value="{{$user->lastname}}" placeholder="" required>
                            <label for="lastname" class="form--label required"> @lang('Last Name')</label>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <input type="text" class="form--control" id="email" value="{{$user->email}}" placeholder="" readonly>
                            <label for="email" class="form--label">@lang('Email')</label>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <input type="text" class="form--control" id="mobile" value="{{$user->mobile}}" placeholder="" readonly>
                            <label for="mobile" class="form--label">@lang('Mobile')</label>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <input type="text" class="form--control" name="address" id="address" value="{{@$user->address->address}}" placeholder="">
                            <label for="address" class="form--label">@lang('Address')</label>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <input type="text" class="form--control" id="state" name="state"
                            value="{{@$user->address->state}}" placeholder="">
                            <label for="state" class="form--label">@lang('State')</label>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <input type="text" class="form--control" id="zip" name="zip"
                            value="{{@$user->address->zip}}" placeholder="">
                            <label for="zip" class="form--label">@lang('Zip')</label>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <input type="text" class="form--control" id="city" name="city"
                            value="{{@$user->address->city}}" placeholder="">
                            <label for="city" class="form--label">@lang('City')</label>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-grou mb-3">
                            <input type="text" class="form--control" id="country" value="{{@$user->address->country}}" disabled placeholder="">
                            <label for="country" class="form--label">@lang('Country')</label>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <button type="submit" class="btn btn--base">@lang('Update')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
