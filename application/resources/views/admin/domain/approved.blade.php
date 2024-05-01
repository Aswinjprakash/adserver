@extends('admin.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--md  table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th>@lang('Publisher Username')</th>
                                <th>@lang('Domain Name')</th>
                                <th>@lang('Site Keywords')</th>
                                <th>@lang('Domain Tracker')</th>
                                <th>@lang('Check Domain')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($approves as $approved)
                                <tr>
                                    <td data-label="@lang('Publisher Username')">
                                        <a href="{{route('admin.publishers.detail',$approved->publisher->id)}}"
                                            target="_blank">{{$approved->publisher->username}}</a>
                                    </td>

                                    <td data-label="@lang('Domain Name')" class="font-weight-bold">
                                        <a  href="http://{{$approved->name}}"
                                            target="_blank">{{$approved->name}}
                                        </a>
                                    </td>
                                    <td data-label="@lang('Site Keywords')">
                                        @foreach(json_decode($approved->keywords) as $index => $item)
                                        {{__($item)}}<br>
                                        @endforeach
                                    </td>
                                    <td data-label="@lang('Domain Tracker')">{{$approved->tracker}}</td>

                                    <td data-label="@lang('Check Domain')">
                                        <a href="{{'http://'.$approved->name.'/'.strtolower(str_replace(' ', '_', $general->site_name)).'.txt'}}"
                                           target="_blank" class="btn btn--success btn-sm" data-toggle="tooltip"
                                           data-original-title="{{trans('Check Domain')}}">
                                            <i class="las la-check-double text--shadow"></i>
                                            @lang('Check Domain')
                                        </a>
                                    </td>

                                    <td data-label="@lang('Action')">
                                        <button class="btn btn--primary btn-sm UnapproveBtn" data-id={{$approved->id}} title="@lang('Unapprove')">
                                            <i class="las la-ban text--shadow"></i>
                                        </button>
                                        <button class="btn btn--danger btn-sm deleteBtn" data-id={{$approved->id}} title="@lang('Delete')">
                                            <i class="las la-trash text--shadow"></i>
                                        </button>
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
            @if ($approves->hasPages())
            <div class="card-footer py-4">
                {{ paginateLinks($approves) }}
            </div>
            @endif
        </div>
    </div>
</div>

{{-- UnapproveBtn modal --}}
<div id="UnapproveBtnModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Domain Approve Confirmation')</h5>
                <button type="button" class="close btn btn--danger btn--sm" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{route('admin.domain.unapprove')}}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p>@lang('Are you sure to') <span class="fw-bold">@lang('Unapprove')</span> <span
                            class="fw-bold withdraw-amount text-success"></span> @lang('this domain') <span
                            class="fw-bold withdraw-user"></span>?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- delete modal --}}
<div id="deleteBtnModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Domain Delete Confirmation')</h5>
                <button type="button" class="close btn btn--danger btn--sm" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{route('admin.domain.delete')}}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p>@lang('Are you sure to') <span class="fw-bold">@lang('delete')</span> <span
                            class="fw-bold withdraw-amount text-success"></span> @lang('this domain') <span
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

        $('.UnapproveBtn').on('click', function() {
            var modal = $('#UnapproveBtnModal');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.modal('show');
        });

        $('.deleteBtn').on('click', function() {
            var modal = $('#deleteBtnModal');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.modal('show');

        });

    </script>

@endpush


