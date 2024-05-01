@extends($activeTemplate.'layouts.frontend')
@section('content')
@php
$contact = getContent('contact_us.content',true);
@endphp

<section class="contact-section py-115">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-content">
                    <h2 class="section-title mb-2 wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">{{__($contact->data_values->title)}}</h2>
                    <div class="title-btm-border mb-3 wow animate__animated animate__fadeInUp"  data-wow-delay="0.3s"></div>
                </div>
            </div>
        </div>
        <div class="row gy-4 py-80">
            <div class="col-lg-6 justify-content-center d-flex flex-column">
                <div class="get-in-touch-box wow animate__animated animate__fadeInUp" data-wow-delay="0.3s">
                    <div class="get-in-touch-thumb">
                        <img src="{{asset($activeTemplateTrue.'images/get-intouch.png')}}" alt="contact-thumb">
                    </div>
                    <div class="get-in-content mb-4">
                        <h3 class="wow animate__animated animate__fadeInUp" data-wow-delay="0.4s">{{__($contact->data_values->title)}}</h3>
                        <p class="wow animate__animated animate__fadeInUp" data-wow-delay="0.5s">{{__($contact->data_values->short_details)}}</p>
                    </div>
                    <div class="info-item mb-4">
                        <h6 class="title wow animate__animated animate__fadeInUp" data-wow-delay="0.6s"><i class="fas fa-phone"></i> @lang('Phone')</h6>
                        <p class="wow animate__animated animate__fadeInUp" data-wow-delay="0.7s"><a href="tel:{{__($contact->data_values->contact_number)}}">{{__($contact->data_values->contact_number)}}</a></p>
                    </div>
                    <div class="info-item mb-4">
                        <h6 class="title wow animate__animated animate__fadeInUp" data-wow-delay="0.8s"><i class="fas fa-envelope"></i> @lang('Email')</h6>
                        <p class="wow animate__animated animate__fadeInUp" data-wow-delay="0.9s"><a href="mailto:{{__($contact->data_values->email_address)}}">{{__($contact->data_values->email_address)}}</a></p>
                    </div>

                    <div class="info-item">
                        <h6 class="title wow animate__animated animate__fadeInUp" data-wow-delay="01s"><i class="fa-solid fa-location-dot"></i> @lang('Address')</h6>
                        <p class="wow animate__animated animate__fadeInUp" data-wow-delay="1.1s">{{__($contact->data_values->contact_details)}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="get-in-touch wow animate__animated animate__fadeInUp" data-wow-delay="0.5s">
                    <h3 class="get-in-touch-title">@lang('Write Your Message')</h3>
                    <form method="post" action="" class="verify-gcaptcha">
                        @csrf
                        <div class="form-group mb-3">
                            <input type="text" class="form--control" name="name" value="@if(auth()->guard('publisher')->check()){{ auth()->guard('publisher')->user()->fullname }}@elseif(auth()->guard('advertiser')->check()){{ auth()->guard('advertiser')->user()->fullname }}@else{{ old('name') }}@endif" placeholder="">
                            <label for="name" class="form--label">@lang('Name')</label>
                        </div>
                        <div class="form-group mb-3">
                            <input type="email" class="form--control" name="email" value="@if(auth()->guard('publisher')->check()){{ auth()->guard('publisher')->user()->email }}@elseif(auth()->guard('advertiser')->check()){{ auth()->guard('advertiser')->user()->email }}@else{{ old('email') }}@endif" placeholder="" >
                            <label for="email" class="form--label">@lang('Email')</label>
                        </div>
                        <div class="form-group mb-3">
                            <input type="subject" class="form--control" name="subject" placeholder="" >
                            <label for="subject" class="form--label">@lang('Subject')</label>
                        </div>
                        <div class="form-group mb-3">
                            <textarea class="form--control" name="message" placeholder=""></textarea>
                            <label for="email" class="form--label">@lang('Message')</label>
                        </div>
                        <x-captcha></x-captcha>
                        <button class="btn btn--base mt-3"><i class="fas fa-paper-plane"></i> @lang('Send')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="map-section">
        <div class="map-box">
            <iframe src="https://maps.google.com/maps?q={{ $contact->data_values->latitude }},{{ $contact->data_values->longitude }}&hl=es;z=14&amp;output=embed" width="100%" height="450" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</section>

@endsection
