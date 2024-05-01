@php
    $links = getContent('policy_pages.element');
    $contact = getContent('contact_us.content',true);
    $subscribe = getContent('subscribe.content',true);
    $socialIconElements = getContent('social_icon.element',false);
    $importantLinks = getContent('footer_important_links.element', false, null, true);
    $companyLinks = getContent('footer_company_links.element', false, null, true);

@endphp
<!-- ==================== Footer Start Here ==================== -->
<footer class="footer-area section-bg">
    <div class="footer-top py-115">
        <div class="container pt-120">
          <div class="row justify-content-center" >
            <div class="col-xl-10">
              <div class="stay-tune-box text-center" style="background: url({{asset($activeTemplateTrue.'images/card-bg.png')}}); background-size: cover; background-repeat: no-repeat;">
                <h2 class="tune-box-title mb-3">{{__($subscribe->data_values->heading)}}</h2>
                <p  class="tune-box-subtitle mb-4"> {{__($subscribe->data_values->subheading)}}</p>
                <div class="footer-subscribe-box">
                    <form action="{{route('subscribe')}}" method="POST">
                        @csrf
                      <div class="tune-box-input">
                        <input class="form--control footer-input" name="email" type="text" placeholder="@lang('Email')...">
                      </div>
                      <button class="btn btn--base search-btn ms-3" type="submit">@lang('Subscribe')</button>
                  </form>
              </div>
              </div>
            </div>
          </div>
            <div class="row gy-4 justify-content-center">
                <div class="col-xl-3 col-sm-6">
                    <div class="footer-item">
                        <div class="footer-item__logo wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                            <a href="{{route('home')}}" class="footer-logo-normal" id="footer-logo-normal"> <img src="{{ getImage(getFilePath('logoIcon').'/logo.png', '?'
                                .time()) }}" alt="{{config('app.name')}}">
                            </a>
                            <a href="{{route('home')}}" class="footer-logo-dark hidden" id="footer-logo-dark"> <img src="{{ getImage(getFilePath('logoIcon').'/logo_white.png', '?'
                                .time()) }}" alt="{{config('app.name')}}">
                            </a>
                        </div>
                        <p class="footer-item__desc wow animate__animated animate__fadeInUp" data-wow-delay="0.3s">{{__($contact->data_values->short_details)}}</p>

                        <ul class="social-list wow animate__animated animate__fadeInUp" data-wow-delay="1s">
                            @foreach($socialIconElements as $item)
                            <li class="social-list__item"><a href="{{__($item->data_values->url)}}" class="social-list__link">@php echo $item->data_values->social_icon @endphp</a> </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="footer-item">
                        <h5 class="footer-item__title">@lang('Important Links')</h5>
                        <ul class="footer-menu">
                            @foreach($importantLinks as $key=>$item)
                            <li class="footer-menu__item"><a href="{{url('/').$item->data_values->url}}" class="footer-menu__link">{{$item->data_values->title}} </a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="footer-item">
                        <h5 class="footer-item__title">@lang('Company Links')</h5>
                        <ul class="footer-menu">
                            @foreach($links as $link)
                            <li class="footer-menu__item"><a href="{{ route('policy.pages', [slug($link->data_values->title), $link->id]) }}" target="_blank">{{$link->data_values->title}}</a></li>
                            @endforeach
                            <li class="footer-menu__item"><a href="{{url('/cookie-policy')}}" target="_blank">@lang('Cookie Policy')</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="footer-item">
                        <h5 class="footer-item__title">@lang('Contact Us')!</h5>
                        <div class="footer-contact-info mb-2">
                            <i class="fas fa-phone"></i>
                          <p><span>@lang('Call Us')</span> <br><a href="tel:{{__($contact->data_values->contact_number)}}">{{__($contact->data_values->contact_number)}}</a> </p>
                        </div>
                        <div class="footer-contact-info mb-2">
                            <i class="fas fa-envelope"></i>
                          <p><span>@lang('Send Email')</span> <br><a href="mailto:{{__($contact->data_values->email_address)}}">{{__($contact->data_values->email_address)}}</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  <!-- Footer Top End-->

    <!-- bottom Footer -->
    <div class="bottom-footer section-bg py-3">
        <div class="container">
            <div class="row text-center gy-2">
                <div class="col-lg-12">
                    <div class="bottom-footer-text"> @php echo $contact->data_values->website_footer;  @endphp</div>
                </div>
            </div>
        </div>
    </div>
  </footer>
  <!-- ==================== Footer End Here ==================== -->




  <div class="scroll-top show">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
      <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 197.514;">
      </path>
    </svg>
    <i class="fas fa-arrow-up"></i>
  </div>
<!-- footer -->
