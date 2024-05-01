@extends($activeTemplate.'layouts.publisher.master')
@section('content')
<div class="row gy-4 justify-content-center">
    <div class="col-lg-12">
        <div class="order-wrap">
            <div class="row justify-content-end">
                <div class="col-md-12 mb-3 text-end">
                    <button type="button" class="btn btn--base addModal" data-toggle="modal"><i
                        class="fas fa-plus"></i>
                    @lang('Add Domain')
                </button>
                </div>
            </div>
            <table class="table table--responsive--lg">
                <thead>
                    <tr>
                        <th>@lang('Domain Name')</th>
                        <th>@lang('Site Keywords')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($domains as $dv)
                  <tr>
                     <td data-label="@lang('Domain Name')">{{__($dv->name)}}</td>
                     <td data-label="@lang('Site Keywords')">
                        @foreach(json_decode($dv->keywords) as $index => $item)
                           {{__($item)}}<br>
                        @endforeach
                     </td>
                     <td data-label="@lang('Status')">
                        @php
                            echo $dv->statusBadge($dv->status);
                        @endphp
                     </td>
                    <td data-label="@lang('Action')">
                     @if ($dv->status==0)
                        <a href="{{route('publisher.domain.verify.action',$dv->tracker)}}" class="btn btn--success btn--sm" title="@lang('verify')">
                        <i class="las la-check-circle"></i>
                        </a>
                        <a href="{{route('publisher.domain.edit',$dv->id)}}" class="btn btn--base btn--sm" title="Edit">
                            <i class="las la-edit text--shadow "></i>
                        </a>
                     @endif
                        <a href="javascript:void(0)" class="btn btn--danger btn--sm rejectBtn" title="@lang('Delete')" data-id={{$dv->id}}>
                                <i class="las la-trash"></i>
                        </a>
                      </td>
                  </tr>
                  @empty
                      <tr>
                          <td data-label="@lang('Domain Table')" class="text-muted text-center" colspan="100%">{{ $emptyMessage }}</td>
                      </tr>
                  @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($domains->hasPages())
    <div class="d-flex justify-content-end">
        {{ paginateLinks($domains) }}
    </div>
    @endif
</div>

    <!--add modal-->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form action="{{route('publisher.domain.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> @lang('Add Domain')</h5>
                        <button type="button" class="close btn btn--danger btn--sm" data-bs-dismiss="modal" aria-label="Close">
                            <i class="las la-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group mb-3">
                                <input type="text" class="form--control" name="name" value="{{ old('name') }}" placeholder=" " required>
                                <label class="form--label on-modal-lable">@lang('Domain Name')</label>
                            </div>
                            <div class="form-group mb-3  keywords-select">
                                <select name="keywords[]" class="form--control select2-auto-tokenize w-100" multiple="multiple">
                                     @foreach($keywords as $key=> $item)
                                     <option value="{{$item->keywords}}">{{__($item->keywords)}}</option>
                                     @endforeach
                                </select>
                                <label for="keywords" class="form--label required"> @lang('Keywords') <span class="text-danger">* @lang('reserved keywords')</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--base">@lang('Submit')</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    {{-- delete modal --}}
    <div id="rejectModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Delete Domain Confirmation')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{route('publisher.domain.delete')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>@lang('Are you sure to') <span class="fw-bold">@lang('delete')</span> <span
                                class="fw-bold withdraw-amount text-success"></span> @lang('this domain') <span
                                class="fw-bold withdraw-user"></span>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--danger btn-global">@lang('Delete')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@push('style')
<style>
    .select2-container{
        width: 100% !important;
    }
</style>
@endpush

@push('script')
    <script>
        'use strict';

        $('.select2-auto-tokenize').select2({
            dropdownParent: $('.keywords-select'),
            tags: true,
            tokenSeparators: [',']
        });


        $('.addModal').on('click', function() {
            $('#addModal').modal('show');
        });

        $('.rejectBtn').on('click', function () {
            var modal = $('#rejectModal');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.modal('show');
        });

    </script>
@endpush

