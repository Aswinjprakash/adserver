
@extends($activeTemplate.'layouts.advertiser.master')
@section('content')
<div class="row gy-4 justify-content-center">
    <div class="col-lg-12 justify-content-center">
        <div class="user-profile payment-info">
            <form action="{{route('advertiser.ad.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="ad_name" value="{{$adType->ad_name}}">
                <input type="hidden" name="ad_type_id" value="{{$adType->id}}">
                <input type="hidden" value="{{ Auth::guard('advertiser')->user()->id }}" name="advertiser">
                <div class="row gy-3">
                    <div class="col-lg-4">
                        <div class="form-group mb-3">
                            <input type="text" class="form--control" id="title" name="title" placeholder="" required>
                            <label for="title" class="form--label required"> @lang('Title') <span class="text-danger">*</span></label>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group mb-3">
                            <select  class="select form--control" name="type" required>
                                <option value="click">@lang('Click')</option>
                                <option value="impression">@lang('Impression')</option>
                            </select>
                            <label for="title" class="form--label required"> @lang('Type') <span class="text-danger">*</span></label>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group mb-3">
                            <input type="text" class="form--control" id="url" name="url" placeholder="" required>
                            <label for="url" class="form--label required"> @lang('Redirect URL') <span class="text-danger">*</span></label>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group mb-3">
                            <select name="keywords[]" class="form--control select2-auto-tokenize w-100" multiple="multiple">
                                 @foreach($keywords as $key=> $item)
                                 <option value="{{$item->keywords}}">{{__($item->keywords)}}</option>
                                 @endforeach
                            </select>
                            <label for="keywords" class="form--label required"> @lang('Keywords') <span class="text-danger">* @lang('reserved keywords')</span></label>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group mb-3">
                            <select name="country[]" class="form--control select3-auto-tokenize w-100 country" multiple="multiple">
                                 @foreach($countries as $key=> $item)
                                 <option value="{{$item->country}}">{{__($item->country)}}</option>
                                 @endforeach
                            </select>
                            <label for="country" class="form--label required"> @lang('Countries') <span class="text-danger">*</span></label>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group mb-3">
                            <input  type="checkbox" class="form-check-input" id="global" name="global" placeholder="">
                            <label for="global" class="form-check-label">@lang('Target for global')</label>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group mb-3">
                            <div class="file-upload-wrapper" data-text="Select your image!">
                                <input type="file" name="image" id="image"
                                    class="file-upload-field form--control">
                            <label for="demo_link" class="form--label required">@lang('Ad Image') <span class="text-danger">({{$adType->slug}})*</span> </label>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <button type="submit" class="btn btn--base">@lang('Create')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    (function ($) {
        "use strict";

        $('#global').change(function () {
                if ($(this).is(":checked")) {
                    $('.country').attr('disabled', true)
                } else {
                    $('.country').attr('disabled', false)
                }
            })

        $('.select2-auto-tokenize').select2({
            dropdownParent: $('.user-profile'),
            tags: true,
            tokenSeparators: [',']
        });

        $('.select3-auto-tokenize').select2({
            dropdownParent: $('.user-profile'),
            tags: true,
            tokenSeparators: [',']
        });
        
    })(jQuery);
</script>
@endpush
