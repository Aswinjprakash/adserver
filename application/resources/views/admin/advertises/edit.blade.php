@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 mb-30">
            <div class="row gy-4 pb-4">
                <div class="col-xl-4 col-sm-6">
                    <a href="javascript:void(0)">
                        <div class="card prod-p-card background-pattern-white bg--primary">
                            <div class="card-body">
                                <div class="row align-items-center m-b-0">
                                    <div class="col">
                                        <h6 class="m-b-5 text-white">@lang('Total Clicked')</h6>
                                        <h3 class="m-b-0 text-white">{{ $advertise->clicked ?  $advertise->clicked : 0}}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-4 col-sm-6">
                    <a href="javascript:void(0)">
                        <div class="card prod-p-card background-pattern-white bg--white">
                            <div class="card-body">
                                <div class="row align-items-center m-b-0">
                                    <div class="col">
                                        <h6 class="m-b-5">@lang('Total Impression')</h6>
                                        <h3 class="m-b-0 ">{{ $advertise->impression ? $advertise->impression:0}}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-4 col-sm-6">
                    <a href="javascript:void(0)">
                        <div class="card prod-p-card background-pattern-white bg--primary">
                            <div class="card-body">
                                <div class="row align-items-center m-b-0">
                                    <div class="col">
                                        <h6 class="m-b-5 text-white">@lang('Ad Type')</h6>
                                        <h3 class="m-b-0 text-white">{{ ucfirst($advertise->ad_type)}}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <form action="{{route('admin.advertise.ads.update',$advertise->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-xl-5 col-lg-12">
                        <div class="card b-radius--10 overflow-hidden box--shadow1 mt-4 d-inline-block">
                            <div class="card-body p-0">
                                <div class="p-3">
                                    <div><img src="{{ getImage(getFilePath('adImage').'/'.@$advertise->image)}}" height="{{ @$advertise->type->height }}" width="{{ @$advertise->type->width }}"/></div>
                                    <div class="mt-15">
                                        <h4 class="">{{@$advertise->ad_name}} <small class="text-danger">({{ @$advertise->resolution }})@lang('px') </small></h4>
                                        <span class="text--small">@lang('Created At ')<strong>{{date('d M, Y h:i A',strtotime(@$advertise->created_at))}} </strong></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                    <div class="col-xl-7 col-lg-12">
                        <div class="card mt-25">
                            <div class="card-body">
                                <h5 class="card-title mb-15 border-bottom pb-2"><span class="fw-bold text-danger">{{$advertise->ad_name}}</span> @lang('Information')</h5>



                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group ">
                                                <label class="form-control-label font-weight-bold">@lang('Advertiser')</label>
                                                <input class="form-control" type="text" value="{{$advertise->advertiser->username}}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group ">
                                                <label class="form-control-label font-weight-bold">@lang('Name')<span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="name"  value="{{$advertise->ad_name}}" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group ">
                                                <label class="form-control-label font-weight-bold">@lang('Redirect Url ')<span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="url" value="{{$advertise->redirect_url}}">
                                            </div>
                                        </div>
                                    </div>
                                    @if(!empty($advertise->keywords) && (is_array($advertise->keywords) || is_object($advertise->keywords)))
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group ">
                                                <label class="font-weight-bold" for="">@lang('Keywords')<span class="text-danger">*</span></label>
                                                <select name="keywords[]"  class="form-control select2-auto-tokenize" id="keyword" multiple="multiple">
                                                    @foreach(json_decode(@$advertise->keywords) as $key=> $keyword)
                                                    <option value="{{$keyword}}" selected>{{$keyword}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if($advertise->country!=null)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group ">
                                                <label class="font-weight-bold" for="exampleInputPassword1">@lang('Targeted Country')<span class="text-danger">*</span></label>
                                                <select name="country[]" class="form--control select2-auto-tokenize w-100 country" multiple="multiple">
                                                    @foreach(json_decode($advertise->country) as $key=> $item)
                                                    <option value="{{@$item}}" selected>{{__(@$item)}}</option>
                                                    @endforeach
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="custom-control custom-checkbox form-check-primary my-2">
                                                <input  type="checkbox" class="form-check-input"  {{$advertise->global==1?'checked':''}} id="global" name="global" placeholder="">
                                                <label class="custom-control-label font-weight-bold"
                                                    for="customCheck21">@lang('Target for global')</label>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12 text-end">
                        <div class="form-group">
                            <button type="submit" class="btn btn--primary">@lang('Update')
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection

@push('breadcrumb-plugins')
<a href="{{route('admin.advertise.ads.advertise.all')}}" class="btn btn--primary"><i class="las la-backward"></i> @lang('Go Back')</a>
@endpush


@push('script')
    <script>
            (function ($) {
       'use strict';

        $('#global').change(function () {
            if ($(this).is(":checked")) {
                $('.country').attr('disabled', true);
            } else {
                $('.country').attr('disabled', false);
            }
        }).trigger('change');

            })(jQuery);

    </script>
@endpush
