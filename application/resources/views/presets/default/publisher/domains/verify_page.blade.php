@extends($activeTemplate.'layouts.publisher.master')
@section('content')
<div class="row gy-4 justify-content-center">
    <div class="col-lg-6">
        <div class="payment-info">
            <h5 class="global-text">{{$domain->name}}</h5>
            <p class="mt-3 mb-3">
                @lang('To verify the domain, ')
                    <li class="ml-2 dm-info">@lang('Please download the file and Place it to your Domain/Server')</li>
                </p><br><br>
                <button class="btn btn--base downloadFile" onclick="">@lang('Download')</button>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="payment-info">
            @if ($domain->status==0)
            <h5 class="badge badge--danger">@lang('Unverified')</h5>
            @elseif($domain->status==1)
            <h5 class="badge badge--success">@lang('Verified')</h5>
            @else
            <h5 class="badge badge--warning">@lang('Pending')</h5>
            @endif
            <p class="my-3">
                @lang('After upload the file to your domain/Server , The file should be browsable with below URL'):
                <a href="{{$fileURL}}" target="_blank">{{str_replace('http://','',$fileURL)}}</a>
            </p><br>
            @if ($domain->status==0)
                <a class="btn btn--success " href="{{route('publisher.domain.check',$domain->tracker)}}">@lang('Verify Now')</a>
            @elseif($domain->status==1)
            <a class="btn btn--secondary" href="javascript:void(0)">  <i class="menu-icon las la-check-circle"></i>@lang('Verified')</a>
            @else
                <a class="btn btn--secondary" href="javascript:void(0)">  <i class="menu-icon las la-spinner"></i>@lang('Pending')</a>
            @endif
         </div>
    </div>
</div>
@endsection

@push('script')


<script>
  'use strict'

    function download(filename, text) {
     var element = document.createElement('a');
     element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
     element.setAttribute('download', filename);

     element.style.display = 'none';
     document.body.appendChild(element);

     element.click();

     document.body.removeChild(element);
   }

$('.downloadFile').on('click', function(){

   download("{{$fileName}}","{{$domain->verify_code}}");
})

</script>
@endpush


