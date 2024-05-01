@extends($activeTemplate.'layouts.publisher.master')
@section('content')
<div class="row justify-content-center gy-4">
    <div class="col-lg-6">
        <div class="payment-info">
            <form action="{{route('user.withdraw.submit')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-2">
                    @php
                    echo $withdraw->method->description;
                    @endphp
                </div>
                <x-custom-form identifier="id" identifierValue="{{ $withdraw->method->form_id }}"></x-custom-form>
                @if(auth()->guard('publisher')->user()->ts)
                <div class="form-group mb-3">
                    <input type="text" name="authenticator_code" class="form--control" placeholder="" required>
                    <label>@lang('Google Authenticator Code')</label>
                </div>
                @endif
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn--base ">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
