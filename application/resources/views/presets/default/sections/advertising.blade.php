@php
    $advertising = getContent('advertising.content',true);
    $advertisingElements = getContent('advertising.element',false,4);
@endphp
<!-- < popular ad formate -->
<section class="popular-ad-formate-section section-bg py-115">
    <div class="container">
        <div class="col-lg-12">
            <div class="section-content">
                <h2 class="section-title mb-2 wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">{{__($advertising->data_values->heading)}}</h2>
                <div class="title-btm-border mb-3 wow animate__animated animate__fadeInUp"  data-wow-delay="0.3s"></div>
            </div>
        </div>
        @foreach($advertisingElements as $index=>$item)
          @if($index % 2 == 0)

                <div class="row justify-content-center gy-4 wow animate__animated animate__fadeInUp {{ $loop->last ? '' : 'mb-80' }}" data-wow-delay="0.2s">
                    <div class="col-lg-6" >
                    <div class="ad-short-content">
                        <h3 class="mb-3">{{__($item->data_values->title)}}</h3>
                            @php
                            echo $item->data_values->description;
                            @endphp
                    </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="ad-thumb">
                        <img src="{{getImage(getFilePath('advertising').'/'.@$item->data_values->ad_image)}}" alt="popular-ad-thumb">
                        </div>
                    </div>

                </div>
            @else

                <div class="row flex-wrap-reverse gy-4 justify-content-center wow animate__animated {{ $loop->last ? '' : 'mb-80' }} animate__fadeInUp"
                    data-wow-delay="0.3s">
                    <div class="col-lg-6">
                    <div class="ad-thumb-1">
                        <img src="{{getImage(getFilePath('advertising').'/'.@$item->data_values->ad_image)}}" alt="popular-ad-thumb">

                    </div>
                    </div>
                    <div class="col-lg-6">
                    <div class="ad-short-content">
                        <h3 class="mb-3">{{__($item->data_values->title)}}</h3>
                            @php
                            echo $item->data_values->description;
                            @endphp
                    </div>
                    </div>
                </div>

            @endif
        @endforeach
    </div>
</section>
<!--  popular ad formate />-->
