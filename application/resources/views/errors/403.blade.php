
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title> {{ $general->siteName(__('403')) }}</title>

        <link href="{{ asset('assets/common/css/bootstrap.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/main.css')}}">

        <style>
            .erro-body{
                height: 100vh;
            }
        </style>
    </head>

    <body>

    <section class="account">
    <div class="account-inner">
        <div class="container">
            <div class="row gy-4 justify-content-center align-items-center" style="height: 90vh">
                <div class="col-lg-6">
                    <div class="error-wrap text-center">
                        <div class="eye-box">
                            <div class="eye"></div>
                            <div class="eye"></div>
                        </div>
                        <div class="error__text">
                            <span>@lang('4')</span>
                            <span>@lang('0')</span>
                            <span>@lang('3')</span>
                        </div>

                        <h2 class="error-wrap__title mb-3">@lang('Page Forbidden')</h2>
                        <p class="error-wrap__desc">@lang('Access to this resource on the server is denied')!</p>
                        <a href="{{route('home')}}" class="btn btn--base">
                            <i class="la la-undo"></i>@lang('Home')
                            <span style="top: 212.016px; left: 168px;"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>

</body>

<script src="{{asset('assets/common/js/jquery-3.7.0.min.js')}}"></script>
<script>
    "use strict";
    $('body').on('mousemove', eyeball);
    function eyeball(event) {
    $('.eye').each(function() {
        let eye = $(this);
        let x = (eye.offset().left) + (eye.width() / 2);
        let y = (eye.offset().top) + (eye.height() / 2);

        let radian = Math.atan2(event.pageX - x, event.pageY - y);
        let rotation = (radian * (180 / Math.PI) * -1) + 270;

        eye.css('transform', 'rotate(' + rotation + 'deg)');
    });
    }
</script>
</html>


