@extends($activeTemplate.'layouts.advertiser.master')
@section('content')
<div class="row gy-4 justify-content-center">
    <div class="col-lg-12">
        <div class="order-wrap">
            <div class="row justify-content-end">
                <div class="col-md-3 mb-3">
                    <div class="search-box w-100">
                        <form action="{{route('advertiser.report.date.search')}}" method="GET">
                            <div class="form-group">
                            <input type="text" name="date" autocomplete="off"  data-range="true" data-multiple-dates-separator=" - " data-language="en" class="datepicker-here form--control" data-position='bottom left' placeholder="">
                            <label class="form--label">@lang('Start to End Date')</label>
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
                        <th>@lang('TRX')</th>
                        <th>@lang('Amount')</th>
                        <th>@lang('Detail')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $trx)
                        <tr>
                            <td data-label="@lang('Date')">{{ showDateTime($trx->created_at,'d M Y')}}</td>
                            <td data-label="@lang('TRX')" class="font-weight-bold">{{ $trx->trx }}</td>

                            <td data-label="@lang('Amount')" class="budget">
                                <strong @if($trx->trx_type == '+') class="text-success" @else class="text-danger" @endif> {{($trx->trx_type == '+') ? '+':'-'}} {{getAmount($trx->amount)}} {{$general->cur_text}}</strong>
                            </td>
                            <td data-label="@lang('Detail')">{{__($trx->details)}}</td>
                        </tr>
                    @empty
                        <tr>
                            <td data-label="@lang('Per Day Report Table')" class="text-muted text-center" colspan="100%">{{__($emptyMessage)}}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($transactions->hasPages())
    <div class=" d-flex justify-content-end">
        {{ paginateLinks($transactions) }}
    </div>
    @endif
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







