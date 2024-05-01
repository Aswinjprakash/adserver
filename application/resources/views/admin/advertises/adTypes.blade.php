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
                                <th>@lang('Ad Type')</th>
                                <th>@lang('Width')</th>
                                <th>@lang('Height')</th>
                                <th>@lang('Ad Slug')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($adTypes as $type)
                            <tr>
                                <td data-label="@lang('Ad Name')"> {{$type->ad_name}}</td>
                                <td data-label="@lang('Ad Type')"><span
                                        class="text--small badge font-weight-normal badge--warning">{{$type->type}}</span>
                                </td>
                                <td data-label="@lang('Width')">{{ $type->width }}@lang('px')</td>
                                <td data-label="@lang('Height')">{{ $type->height }}@lang('px')</td>
                                <td data-label="@lang('Ad Slug')">{{ $type->slug }}@lang('px')</td>
                                <td data-label="@lang('Status')"><span
                                        class="text--small badge font-weight-normal {{ $type->status ==1 ?'badge--success':'badge--warning'}}">{{ $type->status == 1 ? 'Active':'Deactive' }}</span>
                                </td>
                                <td data-label="Action">
                                    <button type="button" class="btn btn-sm btn--primary edit"
                                            data-id="{{$type->id}}"
                                            data-name="{{$type->ad_name}}"
                                            data-type="{{$type->type}}"
                                            data-width="{{$type->width}}"
                                            data-height="{{$type->height}}"
                                            data-slug="{{$type->slug}}"
                                            data-status="{{$type->status}}">
                                        <i class="las la-pen text--shadow"></i>
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
            @if ($adTypes->hasPages())
            <div class="card-footer py-4">
                {{ paginateLinks($adTypes) }}
            </div>
            @endif
        </div><!-- card end -->
    </div>
</div>



    <!--add modal-->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form action="{{route('admin.advertise.ads.adType.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> @lang('Add new Type')</h5>
                        <button type="button" class="close btn btn-outline--danger" data-bs-dismiss="modal" aria-label="Close">
                            <i class="las la-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group">
                                <label  for="name"> @lang('Ad Name'):</label>
                                <input type="text" class="form-control" name="ad_name" value="{{ old('ad_name') }}" placeholder="@lang('Ad Name')" required>
                            </div>

                            <div class="form-group">
                                <label for="type"> @lang('Type'):</label>
                                <input type="text" class="form-control" placeholder="@lang('Type')"
                                        name="type" value="image" value="{{ old('type') }}" required readonly>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="width">@lang('Width'): (<span class="text-danger">@lang('px')</span>)</label>
                                    <input type="number" class="form-control" placeholder="@lang('width')"
                                            name="width" id="width" value="{{ old('width') }}" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="height"> @lang('Height'): (<span class="text-danger">@lang('px')</span>)</label>
                                    <input type="number" class="form-control" placeholder="@lang('Height')"
                                            name="height" id="height" value="{{ old('height') }}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="slug">@lang('Slug'): (<span class="text-danger">@lang('px')</span>)</label>
                                <input class="form-control" type="text" placeholder="@lang('Slug')"
                                id="slug" name="slug" value="" required readonly>
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
            <form action="{{route('admin.advertise.ads.adType.update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> @lang('Update')</h5>
                        <button type="button" class="close btn btn-outline--danger" data-bs-dismiss="modal" aria-label="Close">
                            <i class="las la-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group">
                                <label  for="ad_name"> @lang('Ad Name'):</label>
                                <input type="text" class="form-control" name="ad_name" value="{{ old('ad_name') }}" placeholder="@lang('Ad Name')" required>
                            </div>

                            <div class="form-group">
                                <label for="type"> @lang('Type'):</label>
                                <input type="text" class="form-control" placeholder="@lang('Type')"
                                        name="type" value="image" value="{{ old('type') }}" required readonly>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="width">@lang('Width'): (<span class="text-danger">@lang('px')</span>)</label>
                                    <input type="number" class="form-control" placeholder="@lang('width')"
                                            name="width" id="widthU" value="{{ old('width') }}" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="height"> @lang('Height'): (<span class="text-danger">@lang('px')</span>)</label>
                                    <input type="number" class="form-control" placeholder="@lang('Height')"
                                            name="height" id="heightU" value="{{ old('height') }}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="slug">@lang('Slug'): (<span class="text-danger">@lang('px')</span>)</label>
                                <input class="form-control" type="text" placeholder="@lang('Slug')"
                                id="slugU" name="slug" value="" required readonly>
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
                        <button type="submit" class="btn btn--primary">@lang('Submit')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection

@push('breadcrumb-plugins')
    <button type="button" class="btn btn--primary addModal" data-toggle="modal"><i
            class="fas fa-plus"></i>
        @lang('Add new')
    </button>
@endpush


@push('script')
    <script>
        'use strict';


        $('.addModal').on('click', function() {
            $('#addModal').modal('show');
        });

        var input, input2;
        $('#width').on('keyup', function () {
            input = $(this).val();
            $('#slug').val(input);
            if (input == '') {
                $('#slug').val('');
            }
        });
        $('#height').on('keyup', function () {
            input2 = $(this).val();
            $('#slug').val(input + 'x' + input2);
            if (input2 == '') {
                $('#slug').val('');
            }
        })

        // update
        var input3, input4;
        $('#widthU').on('keyup', function () {
            input3 = $(this).val();
            $('#slugU').val(input3);
            if (input == '') {
                $('#slugU').val('');
            }
        });
        $('#heightU').on('keyup', function () {
            input4 = $(this).val();
            $('#slugU').val(input3 + 'x' + input4);
            if (input4 == '') {
                $('#slugU').val('');
            }
        })

        var modal = $('#editModal');
        $('.edit').on('click', function () {
            var name = $(this).data('name');
            var type = $(this).data('type')
            var width = $(this).data('width')
            var height = $(this).data('height')
            var slug = $(this).data('slug')
            var status = $(this).data('status')
            var id = $(this).data('id')

            modal.find('input[name=id]').val(id)
            modal.find('input[name=ad_name]').val(name)
            modal.find('input[name=type]').val(type)
            modal.find('input[name=width]').val(width)
            modal.find('input[name=height]').val(height)
            modal.find('input[name=slug]').val(slug)

            if (status == 1) {
                modal.find('input[name=status]').attr('checked', 'checked')
            }
            modal.modal('show')
        })
    </script>

@endpush


