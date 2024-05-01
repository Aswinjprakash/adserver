@extends($activeTemplate . 'layouts.advertiser.master')
@section('content')
    <div class="row gy-4 justify-content-center">
        <div class="col-lg-12 justify-content-center">
            <div class="row gy-4 mb-5">
                <div class="col-xl-4 col-lg-6 col-sm-6">
                    <a class="d-block" href="javascripty:void(0)">
                        <div class="dashboard-card">
                            <span class="banner-effect-1"></span>
                            <div class="dashboard-card__icon">
                                <img src="{{asset($activeTemplateTrue.'dashboardImages/impression.png')}}" alt="ads">
                            </div>
                            <div class="dashboard-card__content">
                                <h5 class="dashboard-card__title">@lang('Total Impression')</h5>
                                <h5 class="dashboard-card__amount">{{ $ad->impression ? $ad->impression : 0 }}</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-4 col-lg-6 col-sm-6">
                    <a class="d-block" href="javascripty:void(0)">
                        <div class="dashboard-card">
                            <span class="banner-effect-1"></span>
                            <div class="dashboard-card__icon">
                                <img src="{{asset($activeTemplateTrue.'dashboardImages/click.png')}}" alt="ads">

                            </div>
                            <div class="dashboard-card__content">
                                <h5 class="dashboard-card__title">@lang('Total Clicked')</h5>
                                <h5 class="dashboard-card__amount">{{ $ad->clicked ? $ad->clicked : 0 }}</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-4 col-lg-6 col-sm-6">
                    <a class="d-block" href="javascripty:void(0)">
                        <div class="dashboard-card">
                            <span class="banner-effect-1"></span>
                            <div class="dashboard-card__icon">
                                @if($ad->ad_type == 'click')
                                <img src="{{asset($activeTemplateTrue.'dashboardImages/click.png')}}" alt="ads">
                                @else
                                <img src="{{asset($activeTemplateTrue.'dashboardImages/click.png')}}" alt="ads">
                                @endif
                            </div>
                            <div class="dashboard-card__content">
                                <h5 class="dashboard-card__title">@lang('Ad Type')</h5>
                                <h5 class="dashboard-card__amount">{{ ucfirst($ad->ad_type) }}</h5>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row gy-4 mb-5">
                <div class="col-lg-4">
                    <div class="payment-info">
                        <p>@lang('Size of') {{ __($ad->ad_name) }} <span
                                class="text-danger">({{ __($ad->resolution) }})</span></p>
                        <hr>
                        <img src="{{ getImage(getFilePath('adImage') . '/' . @$ad->image) }}" alt="Image"
                            class="rounded adimagList">
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="user-profile payment-info">
                        <form action="{{ route('advertiser.ad.update', $ad->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row gy-3">
                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <input type="text" class="form--control" id="ad_name" name="ad_name"
                                            value="{{ $ad->ad_name }}" placeholder="" disabled required>
                                        <label for="ad_name" class="form--label required"> @lang('Type') <span
                                                class="text-danger">*</span></label>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <input type="text" class="form--control" id="title" name="title"
                                            value="{{ $ad->title }}" placeholder="" required>
                                        <label for="title" class="form--label required"> @lang('Title') <span
                                                class="text-danger">*</span></label>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <input type="text" class="form--control" id="url" name="url"
                                            value="{{ $ad->redirect_url }}" placeholder="" required>
                                        <label for="url" class="form--label required"> @lang('Redirect URL') <span
                                                class="text-danger">*</span></label>
                                    </div>
                                </div>
                                @if ($ad->keywords != null)
                                    <div class="col-lg-12">
                                        <div class="form-group mb-3">
                                            <select name="keywords[]" class="form--control select2-auto-tokenize w-100"
                                                multiple="multiple">
                                                @foreach (json_decode($ad->keywords) as $key => $keyword)
                                                    <option value="{{ @$keyword }}" selected>{{ __(@$keyword) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="keywords" class="form--label required"> @lang('Keywords') <span
                                                    class="text-danger">* @lang('reserved keywords')</span></label>
                                        </div>
                                    </div>
                                @endif
                                @if ($ad->country != null)
                                    <div class="col-lg-12">
                                        <div class="form-group mb-3">
                                            <select name="country[]"
                                                class="form--control select3-auto-tokenize w-100 country"
                                                multiple="multiple">
                                                @foreach (json_decode($ad->country) as $key => $item)
                                                    <option value="{{ @$item }}" selected>{{ __(@$item) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="country" class="form--label required"> @lang('Countries') <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <input type="checkbox" class="form-check-input" {{ $ad->global == 1 ? 'checked' : '' }}
                                            id="global" name="global" placeholder="">
                                        <label for="global" class="form-check-label">@lang('Target for global')</label>
                                    </div>
                                </div>

                                <div class="col-lg-12 text-end">
                                    <button type="submit" class="btn btn--base">@lang('Update')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $('#global').change(function() {
                if ($(this).is(":checked")) {
                    $('.country').attr('disabled', true);
                } else {
                    $('.country').attr('disabled', false);
                }
            }).trigger('change');



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
