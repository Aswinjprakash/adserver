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
                                <th>@lang('Date')</th>
                                <th>@lang('Keywords')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($keywords as $keyword)
                            <tr>
                                <td data-label="@lang('Date')">{{showDateTime($keyword->created_at)}}</td>

                                <td data-label="@lang('Keywords')">{{$keyword->keywords}}</td>
                                <td data-label="Action">
                                    <button type="button" class="btn btn-sm btn--primary edit" title="Edit"
                                            data-id="{{($keyword->id)}}"
                                            data-keyword="{{$keyword->keywords}}">
                                        <i class="las la-edit text--shadow"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{__($emptyMessage) }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table><!-- table end -->
                </div>
            </div>
            @if ($keywords->hasPages())
            <div class="card-footer py-4">
                {{ paginateLinks($keywords) }}
            </div>
            @endif
        </div><!-- card end -->
    </div>
</div>


@php
$keyword = <<<EOR
keyword one
keyword two
keyword three
EOR;
@endphp


    <!--add modal-->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form action="{{route('admin.advertise.ads.keyword.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> @lang('Add Keywords')</h5>
                        <button type="button" class="close btn btn-outline--danger" data-bs-dismiss="modal" aria-label="Close">
                            <i class="las la-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group">
                                <label  for="name"> @lang('Keywords'):</label><br>
                                <span>@lang('Separate multiple keywords in new line by press enter key')</span>
                                <textarea type="text" class="form-control mt-2" name="keywords" value="{{ old('keywords') }}" placeholder="{{__($keyword)}}" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary">@lang('Submit')</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <!--edit modal-->
   <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{route('admin.advertise.ads.keyword.update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> @lang('Update Keyword')</h5>
                        <button type="button" class="close btn btn-outline--danger" data-bs-dismiss="modal" aria-label="Close">
                            <i class="las la-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group">
                                <label  for="name"> @lang('Keyword'):</label><br>
                                <input type="text" class="form-control mt-2" name="keyword" value="{{ old('keywords') }}" placeholder="@lang('Keyword')" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary">@lang('Update')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <button type="button" class="btn btn--primary addModal" data-toggle="modal"><i
            class="fas fa-plus"></i>
        @lang('Add Keyword')
    </button>
@endpush


@push('script')
    <script>
        'use strict';

        $('.addModal').on('click', function() {
            $('#addModal').modal('show');
        });

        var modal = $('#editModal');
        $('.edit').on('click', function () {
            var keyword = $(this).data('keyword');
            var id = $(this).data('id')
            modal.find('input[name=id]').val(id)
            modal.find('input[name=keyword]').val(keyword)
            modal.modal('show')
        })
    </script>
@endpush


