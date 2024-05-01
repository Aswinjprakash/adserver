@php
    $feature = getContent('feature.content',true);
    $featureElements = getContent('feature.element',false,9);
@endphp
<!-- < why-choose-section -->
<section class="why-choose-section py-115">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-content">
                    <h2 class="section-title mb-2 wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">{{__($feature->data_values->heading)}}</h2>
                    <div class="title-btm-border mb-3 wow animate__animated animate__fadeInUp"  data-wow-delay="0.3s"></div>
                </div>
            </div>
        </div>
      <div class="row g-4">
        @foreach($featureElements as $item)
          <div class="col-lg-4 col-sm-6">
              <div class="why-choose-card wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                  <div class="icon-thumb mb-3">
                      <img src="{{getImage(getFilePath('feature').'/'.@$item->data_values->feature_image)}}" alt="feature-icon">
                  </div>
                  <div class="why-choose-card-content">
                      <h6>{{__($item->data_values->title)}}</h6>
                      <p>
                        @if(strlen(__($item->data_values->description)) >70)
                        {{substr( __($item->data_values->description), 0,70).'...' }}
                        @else
                        {{__($item->data_values->description)}}
                        @endif
                      </p>
                  </div>
              </div>
          </div>
          @endforeach

      </div>
    </div>
  </section>
  <!--  why-choose-section /> -->
