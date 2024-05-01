@extends('admin.layouts.app')
@section('panel')

<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th>@lang('Ip')</th>
                                <th>@lang('Advertise')</th>
                                <th>@lang('Ad Type')</th>
                                <th>@lang('Country')</th>
                                <th>@lang('Time')</th>
                                <th>@lang('Date')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)

                            <tr>
                                <td data-label="@lang('Ip')">{{$log->ip->ip}}</td>
                                <td data-label="@lang('Advertise')"><a href="#">{{$log->ad->title}}</a></td>
                                <td data-label="@lang('Ad Type')">{{$log->ad_type}}</td>
                                <td data-label="@lang('Country')"><span class="text--small badge font-weight-normal badge--primary">{{$log->country}}</span></td>
                                <td data-label="@lang('Time')">{{\Carbon\Carbon::parse($log->time)->format('g:i A')}}</td>
                                <td data-label="@lang('Date')">{{showDateTime($log->created_at,'d M Y')}}</td>
                                <td data-label="@lang('Action')">

                                    <a href="javascript:void(0)" class="btn btn--danger blockipBtn" data-id="{{$log->ip->id}}" title="@lang('Block IP')">
                                        <i class="las la-ban text--shadow"></i>
                                    </a>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ $emptyMessage }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table><!-- table end -->
                </div>
            </div>
            @if ($logs->hasPages())
            <div class="card-footer py-4">
                {{ paginateLinks($logs) }}
            </div>
            @endif
        </div><!-- card end -->
    </div>
</div>


 {{-- block ip modal --}}
 <div id="blockipBtnModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('IP Block Confirmation')</h5>
                <button type="button" class="close btn btn--danger btn--sm" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{route('admin.advertise.ads.blockedip')}}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p>@lang('Are you sure to') <span class="fw-bold">@lang('block')</span> <span
                            class="fw-bold withdraw-amount text-success"></span> @lang('this ip') <span
                            class="fw-bold withdraw-user"></span>?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection


@push('script')
    <script>
        'use strict';

        $('.blockipBtn').on('click', function() {
            var modal = $('#blockipBtnModal');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.modal('show');
        });


    </script>

@endpush


