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
                                <th>@lang('Name')</th>
                                <th>@lang('Price')</th>
                                <th>@lang('Type')</th>
                                <th>@lang('Points')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($plans as $plan)
                            <tr>
                                <td data-label="@lang('Name')">{{ $plan->name }}</td>
                                <td data-label="@lang('Price')">{{$general->cur_sym}} {{ getAmount($plan->price) }}</td>
                                <td data-label="@lang('Type')"><span
                                        class="text--small badge font-weight-normal {{$plan->type=='click' ? 'badge--dark':'badge--warning'}} bg--">{{ ucfirst($plan->type) }}</span>
                                </td>
                                <td data-label="@lang('Points')">{{ getAmount($plan->points) }}</td>
                                <td data-label="@lang('Status')"><span
                                        class="text--small badge font-weight-normal {{ $plan->status ==1 ?'badge--success':'badge--warning'}}">{{ $plan->status ==1?'Active':'Deactive' }}</span>
                                </td>
                                <td data-label="@lang('Actions')">
                                    <button type="button" class="btn btn-sm btn--primary edit"
                                            data-name="{{$plan->name}}"
                                            data-price="{{getAmount($plan->price,2)}}"
                                            data-type="{{$plan->type}}"
                                            data-points="{{getAmount($plan->points)}}"
                                            data-status="{{$plan->status}}"
                                            data-id="{{($plan->id)}}">
                                        <i class="las la-edit text--shadow"></i>
                                    </button>

                                    <button title="@lang('Remove')"
                                    data-id="{{$plan->id}}"
                                       class="btn btn-sm btn--danger rejectBtn">
                                       <i class="las la-trash"></i>
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
            @if ($plans->hasPages())
            <div class="card-footer py-4">
                {{ paginateLinks($plans) }}
            </div>
            @endif
        </div><!-- card end -->
    </div>
</div>



    <!--add modal-->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form action="{{route('admin.plan.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> @lang('Add plan')</h5>
                        <button type="button" class="close btn btn-outline--danger" data-bs-dismiss="modal" aria-label="Close">
                            <i class="las la-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group">
                                <label  for="name"> @lang('Name'):</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="@lang('Name')" required>
                            </div>

                            <div class="form-group">
                                <label for="price"> @lang('Price'): (<span>{{__($general->cur_text)}}</span>)</label>
                                <input type="text" class="form-control" placeholder="@lang('Price')"
                                        name="price" required value="{{ old('price') }}">
                            </div>

                            <div class="form-group">
                                <label for="type">@lang('Type')</label>
                                <select name="type" class="form-control" required>
                                    <option>@lang('select type')</option>
                                    <option value="impression">@lang('Impression')</option>
                                    <option value="click">@lang('Click')</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="points">@lang('Points')</label>
                                <input class="form-control" type="text" placeholder="@lang('Points')"
                                        name="points" value="{{ old('points') }}" required>
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
            <form action="{{route('admin.plan.update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> @lang('Update plan')</h5>
                        <button type="button" class="close btn btn-outline--danger" data-bs-dismiss="modal" aria-label="Close">
                            <i class="las la-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group">
                                <label  for="name"> @lang('Name'):</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="@lang('Name')" required>
                            </div>

                            <div class="form-group">
                                <label for="price"> @lang('Price'): (<span>{{__($general->cur_text)}}</span>)</label>
                                <input type="text" class="form-control" placeholder="@lang('Price')"
                                        name="price" required value="{{ old('price') }}">
                            </div>

                            <div class="form-group">
                                <label for="type">@lang('Type')</label>
                                <select name="type" class="form-control" required>
                                    <option>@lang('select type')</option>
                                    <option value="impression">@lang('Impression')</option>
                                    <option value="click">@lang('Click')</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="points">@lang('Points')</label>
                                <input class="form-control" type="text" placeholder="@lang('Points')"
                                        name="points" value="{{ old('points') }}" required>
                            </div>
                            <div class="form-group">
                                <label> @lang('Status')</label>
                                <label class="switch m-0" for="statuss">
                                    <input type="checkbox" class="toggle-switch" name="status" id="statuss">
                                    <span class="slider round"></span>
                                </label>
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

    {{-- delete modal --}}
    <div id="rejectModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Delete Plan Confirmation')</h5>
                    <button type="button" class="close btn btn--danger" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{route('admin.plan.delete')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>@lang('Are you sure to') <span class="fw-bold">@lang('delete')</span> <span
                                class="fw-bold withdraw-amount text-success"></span> @lang('this plan') <span
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

@push('breadcrumb-plugins')
    <button type="button" class="btn btn--primary addModal" data-toggle="modal"><i
            class="fas fa-plus"></i>
        @lang('Add new Plan')
    </button>
@endpush


@push('script')
    <script>
        'use strict';

        $('.rejectBtn').on('click', function () {
            var modal = $('#rejectModal');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.modal('show');
        });

        $('.addModal').on('click', function() {
            $('#addModal').modal('show');
        });

        var modal = $('#editModal');
        $('.edit').on('click', function () {
            var name = $(this).data('name');
            var price = $(this).data('price')
            var type = $(this).data('type')
            var points = $(this).data('points')
            var status = $(this).data('status')
            var id = $(this).data('id')

            modal.find('input[name=id]').val(id)
            modal.find('input[name=name]').val(name)
            modal.find('input[name=price]').val(price)
            modal.find('select[name=type]').val(type)

            modal.find('input[name=points]').val(points)
            if (status == 1) {
                modal.find('input[name=status]').attr('checked', 'checked')
            }
            modal.modal('show')
        })
    </script>


@endpush


