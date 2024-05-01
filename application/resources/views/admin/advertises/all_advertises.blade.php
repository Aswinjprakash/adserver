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
                                <th>@lang('Ad Name')</th>
                                <th>@lang('Ad title')</th>
                                <th>@lang('Type')</th>
                                <th>@lang('Advertiser')</th>
                                <th>@lang('Impression')</th>
                                <th>@lang('Click')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($advertises as $advertise)

                            <tr>
                                <td data-label="@lang('Ad Name')" class="text--primary">{{ $advertise->ad_name }}</td>
                                <td data-label="@lang('Ad title')" class="text--primary">{{ $advertise->title }}</td>
                                <td data-label="@lang('Type')"><span class="text--small badge font-weight-normal {{$advertise->ad_type=='click'?'badge--primary':'badge--warning'}} ">{{__($advertise->ad_type)}}</span></td>
                                <td data-label="@lang('Advertiser')"><a href="{{route('admin.advertisers.detail',$advertise->advertiser->id)}}">{{__($advertise->advertiser->username) }}</a></td>
                                <td data-label="@lang('Impression')">{{$advertise->impression??'0'}}</td>
                                <td data-label="@lang('Click')">{{$advertise->clicked??'0'}}</td>

                                <td data-label="@lang('Status')">
                                    @php
                                        echo $advertise->statusBadge($advertise->status);
                                    @endphp
                                </td>

                                <td data-label="@lang('Action')">
                                    <a href="{{route('admin.advertise.ads.edit',$advertise->id)}}" class="btn btn-sm btn--primary" data-toggle="tooltip" title="@lang('Edit')">
                                        <i class="las la-edit"></i>
                                    </a>
                                    @if($advertise->status == 1)
                                    <a href="javascript:void(0)" class="btn btn-sm btn--danger deactiveBtn"data-id="{{$advertise->id}}" data-toggle="tooltip" title="@lang('Deactivate')">
                                        <i class="las la-ban"></i>
                                    </a>
                                    @elseIf($advertise->status == 2 || $advertise->status == 0)
                                    <a href="javascript:void(0)" class="btn btn-sm btn--success activeBtn" data-id="{{$advertise->id}}" data-toggle="tooltip" title="@lang('Active')">
                                        <i class="las la-eye"></i>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{__($emptyMessage)}}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table><!-- table end -->
                </div>
            </div>
            @if ($advertises->hasPages())
            <div class="card-footer py-4">
                {{ paginateLinks($advertises) }}
            </div>
            @endif
        </div><!-- card end -->
    </div>
</div>


 {{-- active modal --}}
 <div id="activeBtnModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Advertise Active Confirmation')</h5>
                <button type="button" class="close btn btn--danger btn--sm" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{route('admin.advertise.ads.update.status')}}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <input type="hidden" name="status" value="1">
                <div class="modal-body">
                    <p>@lang('Are you sure to') <span class="fw-bold">@lang('active')</span> <span
                            class="fw-bold withdraw-amount text-success"></span> @lang('this advertise') <span
                            class="fw-bold withdraw-user"></span>?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>


 {{-- deactive modal --}}
 <div id="deactiveBtnModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Advertise Deactiveed Confirmation')</h5>
                <button type="button" class="close btn btn--danger btn--sm" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{route('admin.advertise.ads.update.status')}}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <input type="hidden" name="status" value="0">
                <div class="modal-body">
                    <p>@lang('Are you sure to') <span class="fw-bold">@lang('deactive')</span> <span
                            class="fw-bold withdraw-amount text-success"></span> @lang('this advertise') <span
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

        $('.activeBtn').on('click', function() {
            var modal = $('#activeBtnModal');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.modal('show');
        });

        $('.deactiveBtn').on('click', function() {
            var modal = $('#deactiveBtnModal');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.modal('show');

        });

    </script>

@endpush


