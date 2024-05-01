@php
    $benifit = getContent('benifit.content',true);
    $benifitElements = getContent('benifit.element',false);
@endphp
<!-- < user benefit -->
<section class="user-benefit-section py-115">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-content">
                    <h2 class="section-title mb-2 wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">{{__($benifit->data_values->heading)}}</h2>
                    <div class="title-btm-border mb-3 wow animate__animated animate__fadeInUp"  data-wow-delay="0.3s"></div>
                </div>
            </div>
        </div>
        <div class="row gy-4">
            <div class="col-lg-6">
                <div class="advertise-benefit">
                    <div class="benefit-key-content mb-3">
                        <h3 class="mb-2 wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">{{__($benifit->data_values->subheading)}}</h3>
                        <p class="wow animate__animated animate__fadeInUp" data-wow-delay="0.3s">
                            {{__($benifit->data_values->description)}}
                        </p>
                    </div>
                    <div class="benefit-key-point mb-3">
                        <ul>
                            @foreach($benifitElements as $item)
                            <li class="wow animate__animated animate__fadeInUp" data-wow-delay="0.4s">
                                <span>@php echo $item->data_values->icon; @endphp</span>
                                <p>
                                    {{__($item->data_values->description)}}
                                </p>
                            </li>
                            @endforeach

                        </ul>
                    </div>
                </div>

            </div>

            <div class="col-lg-6 position-relative">
                <div class="user-benefit-right-section wow animate__animated animate__fadeInUp"  data-wow-delay="0.3s">
                    <div class="benefit-section-thumb">
                        <img src="{{getImage(getFilePath('benifit').'/'.@$benifit->data_values->benifit_image1)}}" alt="benefit-thumb">
                    </div>
                    <span class="benefit-section-tag--img top_image_bounce">
                        <img src="{{getImage(getFilePath('benifit').'/'.@$benifit->data_values->benifit_image2)}}" alt="benefit-thumb">
                    </span>
                    <div class="benefit-section-tag top_image_bounce_2">
                    <div class="odometer odometer-auto-theme" data-count="{{__($benifit->data_values->total_clinet)}}"><div class="odometer-inside"><span class="odometer-digit"><span class="odometer-digit-spacer">8</span><span class="odometer-digit-inner"><span class="odometer-ribbon"><span class="odometer-ribbon-inner"><span class="odometer-value">1</span></span></span></span></span><span class="odometer-formatting-mark">,</span><span class="odometer-digit"><span class="odometer-digit-spacer">8</span><span class="odometer-digit-inner"><span class="odometer-ribbon"><span class="odometer-ribbon-inner"><span class="odometer-value">2</span></span></span></span></span><span class="odometer-digit"><span class="odometer-digit-spacer">8</span><span class="odometer-digit-inner"><span class="odometer-ribbon"><span class="odometer-ribbon-inner"><span class="odometer-value">5</span></span></span></span></span><span class="odometer-digit"><span class="odometer-digit-spacer">8</span><span class="odometer-digit-inner"><span class="odometer-ribbon"><span class="odometer-ribbon-inner"><span class="odometer-value">4</span></span></span></span></span></div></div>
                        <p class="tag-text-content">@lang('Our Client')</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--  user benefit /> -->
