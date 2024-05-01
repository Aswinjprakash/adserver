@extends($activeTemplate.'layouts.frontend')
@section('content')
@php
$banner = getContent('banner.content', true);
@endphp
<!-- < Hero Section -->
<section class="hero section-bg py-220">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-6 d-flex align-items-center">
                <div class="hero-content-box">
                    <div class="hero-content">
                        <h1 class="title">{{__($banner->data_values->heading)}} <span class="type"></span></h1>
                        <div class="animate__animated animate__fadeInUp">
                            <p class="hero-subtitle">{{__($banner->data_values->subheading)}}</p>
                        </div>
                    </div>
                    <div class="hero-group-btn mb-3 wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                        <a href="{{route('login')}}" class="btn btn--base me-2">{{__($banner->data_values->button1)}}</a>
                        <a href="{{route('login')}}" class="btn btn--base outline">{{__($banner->data_values->button2)}}</a>
                    </div>
                </div>
            </div>

        <div class="col-lg-6">
            <div class="img-animation-box">
                <span class="hero-section-tag-7">
                    <img src="{{asset($activeTemplateTrue.'images/tag-7.png')}}" alt="@lang('hero-section-thumb')">
                </span>
                <span class="hero-section-tag-5 left_image_bounce">
                    <img src="{{asset($activeTemplateTrue.'images/tag-5.png')}}" alt="@lang('hero-section-thumb')">
                </span>
                <span class="hero-section-tag-2">
                    <img src="{{asset($activeTemplateTrue.'images/tag-2.png')}}" alt="@lang('hero-section-thumb')">
                </span>
                <span class="hero-section-tag-4 top_image_bounce">
                    <img src="{{asset($activeTemplateTrue.'images/tag-4.png')}}" alt="@lang('hero-section-thumb')">
                </span>

                <div class="hero-img-box">
                    <img src="{{getImage(getFilePath('banner').'/'.@$banner->data_values->banner_image)}}" alt="@lang('bannerImage')">
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<!--  Hero Section />-->

@if($sections->secs != null)
@foreach(json_decode($sections->secs) as $sec)
@include($activeTemplate.'sections.'.$sec)
@endforeach
@endif
@endsection

