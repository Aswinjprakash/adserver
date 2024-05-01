@extends($activeTemplate.'layouts.publisher.master')
@section('content')
<div class="row gy-4">
    <!-- < data table -->
    <div class="col-xl-12 col-lg-12 pb-30">
        <div class="card-wrap">
            <table class="table table--responsive--lg">
                <thead>
                    <tr>
                    <th>@lang('Ad Name')</th>
                    <th>@lang('Ad Type')</th>
                    <th>@lang('Ad Width')</th>
                    <th>@lang('Ad Height')</th>
                    <th>@lang('Script')</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($ads as $ad)
                    <tr>
                        <td data-label="@lang('Ad Name')" >{{__($ad->ad_name) }}</td>
                        <td data-label="@lang('Ad Type')" ><span class="badge badge--base">{{__($ad->type) }}</span></td>
                        <td data-label="@lang('Ad Width')" >{{__($ad->width) }}@lang('px')</td>
                        <td data-label="@lang('Ad Height')" >{{__($ad->height) }}@lang('px')</td>
                        <td data-label="@lang('Script')">
                            <div class="copy-script">
                                <textarea class="ad-text-area lead" id="advertScript{{$ad->id}}" readonly><div class='MainAdverTiseMentDiv' data-publisher="{{ Crypt::encryptString(Auth::guard('publisher')->user()->id) }}" data-adsize="{{$ad->slug}}"></div> <script class="adScriptClass" src="{{url('/')}}/assets/ads/ad.js"></script></textarea>
                                <button class="btn btn--sm script-copy-btn copyButton{{ $ad->id }}" onclick="copyToClipboard('#advertScript{{$ad->id}}','{{$ad->id}}')"><i class="fas fa-clipboard"></i> @lang('Copy')</button>
                                <div class="copy-toast t{{$ad->id}} d-none">
                                    @lang('Script Copied')!
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td data-label="@lang('Advertisement Table')" class="text-muted text-center" colspan="100%">{{__($emptyMessage) }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($ads->hasPages())
    <div class="d-flex justify-content-end">
        {{ paginateLinks($ads) }}
    </div>
    @endif
</div>
@endsection

@push('script')

<script>

    function copyToClipboard(element, id) {
    'use strict'

    $(`.t${id}`).removeClass('d-none');
    var $temp = $("<textarea>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();

    $(`.t${id}`).addClass('copy-toast').toast('show');

    setTimeout(function() {
        $(`.t${id}`).removeClass('copy-toast').addClass('d-none');
    }, 1000);
}
</script>
@endpush

