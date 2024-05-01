@extends($activeTemplate.'layouts.advertiser.master')
@section('content')
<div class="row gy-4 justify-content-center">
    <div class="col-lg-12">
        <div class="order-wrap mb-1">
            <form action="">
            <div class="row justify-content">
                <div class="col-md-4 mb-3">
                    <div class="search-box w-100">
                            <div class="form-group">
                                    <input type="text" name="search" value="{{ request()->search }}"
                                        class="form--control" placeholder=" ">
                                <label for="username" class="form--label"> @lang('Trx Number')</label>

                            </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="search-box w-100">
                            <div class="form-group">
                                <select name="type" class="form-select form--control">
                                    <option value="">@lang('All')</option>
                                    <option value="+" @selected(request()->type == '+')>@lang('Plus')</option>
                                    <option value="-" @selected(request()->type == '-')>@lang('Minus')</option>
                                </select>
                                <label class="form--label">@lang('Type')</label>
                            </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="search-box w-100">
                            <div class="form-group">
                                <select class="form-select form--control" name="remark">
                                    <option value="">@lang('Any')</option>
                                    @foreach($remarks as $remark)
                                    <option value="{{ $remark->remark }}" @selected(request()->remark ==
                                        $remark->remark)>{{ __(keyToTitle($remark->remark)) }}</option>
                                    @endforeach
                                </select>
                                <label class="form--label">@lang('Remark')</label>
                            </div>
                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <div class="text-end">
                        <div class="form-group">
                            <button type="submit" class="btn btn--base">@lang('Apply')</button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
            <table class="table table--responsive--lg">
                <thead>
                    <tr>
                        <th>@lang('Trx')</th>
                        <th>@lang('Transacted')</th>
                        <th>@lang('Amount')</th>
                        <th>@lang('Post Balance')</th>
                        <th>@lang('Detail')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $trx)
                        <tr>
                            <td data-label="@lang('Trx')">
                                {{ $trx->trx }}
                            </td>

                            <td data-label="@lang('Transacted')">
                                {{ showDateTime($trx->created_at)}}
                            </td>

                            <td class="budget" data-label="@lang('Amount')">
                                <span
                                    class="fw-bold @if($trx->trx_type == '+')text-success @else text-danger @endif">
                                    {{ $trx->trx_type }} {{showAmount($trx->amount)}} {{ $general->cur_text
                                    }}
                                </span>
                            </td>

                            <td class="budget" data-label="@lang('Post Balance')">
                                {{ showAmount($trx->post_balance) }} {{ __($general->cur_text) }}
                            </td>


                            <td data-label="@lang('Detail')">{{ __($trx->details) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-muted text-center" colspan="100%" data-label="Transection Table">{{ __($emptyMessage) }}</td>
                        </tr>
                        @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
