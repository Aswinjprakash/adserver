@extends($activeTemplate.'layouts.publisher.master')
@section('content')
<div class="row gy-4 justify-content-center">
    <div class="col-lg-12">
        <div class="order-wrap">
            <div class="row justify-content-end">
                <div class="col-md-3 mb-3">
                    <div class="search-box w-100">
                        <form action="{{route('publisher.report.day.earning.search')}}" method="GET">
                            <div class="form-group">
                            <input type="text" name="date" autocomplete="off"  data-range="true" data-multiple-dates-separator=" - " data-language="en" class="datepicker-here form--control" data-position='bottom left' placeholder="">
                            <label class="form--label">@lang('Search by date')</label>
                            <button type="submit"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <table class="table table--responsive--lg">
                <thead>
                    <tr>
                        <th>@lang('Date')</th>
                        <th>@lang('Name')</th>
                        <th>@lang('Amount')</th>
                        <th>@lang('Type')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($perdayEarnings as $item)
                        <tr>
                            <td data-label="@lang('Date')">{{showDateTime($item->created_at,'d M Y') }}</td>
                            <td data-label="@lang('Ad Name')">{{__(@$item->ad->ad_name) }}</td>
                            <td data-label="@lang('Ad Name')">{{__($general->cur_sym)}} {{showAmount($item->amount)}}</td>
                            <td data-label="@lang('Ad Type')"><span class="badge badge--base">{{@$item->ad->ad_type}}</span></td>

                        </tr>
                        @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{__($emptyMessage) }}</td>
                            </tr>
                        @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('script-lib')
<script src="{{asset('assets/common/js/datepicker.min.js')}}"></script>
<script src="{{asset('assets/common/js/datepicker.en.js')}}"></script>
@endpush

@push('script')
<script>
'use strict';
$('.datepicker-here').datepicker();
</script>
@endpush

