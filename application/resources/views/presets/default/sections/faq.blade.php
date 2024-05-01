@php
$faq = getContent('faq.content', true);
$faqElements = getContent('faq.element', false,12);
@endphp
<!-- < faq-section -->
<section class="faq-section py-115">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-content">
                    <h2 class="section-title mb-2 wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">{{ __($faq->data_values->heading) }}</h2>
                    <div class="title-btm-border mb-3 wow animate__animated animate__fadeInUp"  data-wow-delay="0.3s"></div>
                </div>
            </div>
        </div>
        <div class="row gy-4 justify-content-center">
          <div class="col-lg-6">
            <div class="faq-left-side wow animate__animated animate__fadeInUp"  data-wow-delay="0.3s">
               <div class="faq-section-thumb">
                <img src="{{getImage(getFilePath('faq').'/'.@$faq->data_values->faq_image)}}" alt="faq-thumb">
              </div>
            </div>
          </div>
           <!-- < faq -->
            <div class="col-lg-6">
                <div class="accordion custom--accordion accordion-flush" id="accordionExample">
                    @foreach ($faqElements as $item)
                        <div class="accordion-item wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                            <h2 class="accordion-header" id="heading{{ $loop->index }}">
                                <button class="accordion-button {{ $loop->index == 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->index }}" aria-expanded="{{$loop->index == 0 ? 'true': 'false'}}">
                                {{__(@$item->data_values->question)}}
                                </button>
                            </h2>
                            <div id="collapse{{ $loop->index }}" class="accordion-collapse collapse {{$loop->index == 0 ? 'show': ''}}" aria-labelledby="heading{{ $loop->index }}" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                @php echo @$item->data_values->answer; @endphp
                                </div>
                            </div>
                        </div>
                    @endforeach
            </div>
        </div>
    </div>
    </div>
</section>
  <!--  faq-section /> -->
